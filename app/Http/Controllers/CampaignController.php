<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    /**
     * Public listing (read-only, no auth required)
     * Only show active campaigns to the public.
     */
    public function index()
    {
        $campaigns = Campaign::with(['images', 'category'])
            ->where('status', 'active')
            ->latest()
            ->get();
        return response()->json(['data' => $campaigns, 'message' => 'Campaigns retrieved successfully', 'status' => 200]);
    }

    /**
     * Porter creates a campaign — always starts as 'pending' for admin review.
     * Supports optional image upload in the same request.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'category_id'   => 'required|exists:categories,id',
            'title'         => 'required|string|max:255',
            'description'   => 'required|string',
            'target_amount' => 'required|numeric|min:1',
            'start_date'    => 'nullable|date',
            'end_date'      => 'nullable|date|after_or_equal:start_date',
            'image'         => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
        ]);

        $validateData['user_id'] = auth()->id();
        $validateData['status']  = 'pending'; // Always pending until admin approves

        $campaign = Campaign::create($validateData);

        // Handle optional cover image
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('campaigns', 'public');
            $campaign->images()->create(['url' => asset('storage/' . $path)]);
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Campaign submitted for review. An admin will approve it shortly.',
            'data'    => $campaign->load('images'),
        ], 201);
    }

    /**
     * Public single campaign detail.
     */
    public function show($id)
    {
        $campaign = Campaign::with(['images', 'category', 'user', 'donations'])->findOrFail($id);
        return response()->json(['data' => $campaign, 'message' => 'Campaign retrieved successfully', 'status' => 200]);
    }

    /**
     * Porter's own campaigns (all statuses).
     */
    public function myCampaigns()
    {
        $campaigns = Campaign::with(['images', 'category'])
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return response()->json([
            'status' => 'success',
            'data'   => $campaigns,
        ]);
    }

    /**
     * Admin: approve a pending campaign → status becomes 'active'.
     */
    public function approve($id)
    {
        $campaign = Campaign::findOrFail($id);
        $campaign->update(['status' => 'active']);

        return response()->json([
            'status'  => 'success',
            'message' => 'Campaign approved and is now live.',
            'data'    => $campaign,
        ]);
    }

    /**
     * Admin: reject a pending campaign → status becomes 'cancelled'.
     */
    public function reject($id)
    {
        $campaign = Campaign::findOrFail($id);
        $campaign->update(['status' => 'cancelled']);

        return response()->json([
            'status'  => 'success',
            'message' => 'Campaign has been rejected.',
            'data'    => $campaign,
        ]);
    }

    /**
     * Admin: list all pending campaigns.
     */
    public function pending()
    {
        $campaigns = Campaign::with(['images', 'category', 'user'])
            ->where('status', 'pending')
            ->latest()
            ->get();

        return response()->json([
            'status' => 'success',
            'data'   => $campaigns,
        ]);
    }

    /**
     * Update campaign (owner or admin).
     */
    public function update(Request $request, $id)
    {
        $campaign = Campaign::findOrFail($id);

        if ($campaign->user_id !== auth()->id() && auth()->user()->role !== 'admin') {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized.'], 403);
        }

        $validatedData = $request->validate([
            'category_id'   => 'sometimes|exists:categories,id',
            'title'         => 'sometimes|string|max:255',
            'description'   => 'sometimes|string',
            'target_amount' => 'sometimes|numeric|min:1',
            'start_date'    => 'sometimes|date',
            'end_date'      => 'sometimes|date|after_or_equal:start_date',
            'status'        => 'sometimes|in:pending,active,completed,cancelled',
        ]);

        $campaign->update($validatedData);

        return response()->json(['status' => 'success', 'message' => 'Campaign updated successfully', 'data' => $campaign]);
    }

    /**
     * Delete campaign (owner or admin).
     */
    public function destroy($id)
    {
        $campaign = Campaign::findOrFail($id);

        if ($campaign->user_id !== auth()->id() && auth()->user()->role !== 'admin') {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized.'], 403);
        }

        $campaign->delete();

        return response()->json(['status' => 'success', 'message' => 'Campaign deleted successfully']);
    }

    /**
     * Upload image to campaign gallery.
     */
    public function uploadImage(Request $request, $id)
    {
        $campaign = Campaign::findOrFail($id);

        if ($campaign->user_id !== auth()->id() && auth()->user()->role !== 'admin') {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized.'], 403);
        }

        $request->validate(['image' => 'required|image|mimes:jpeg,png,jpg,gif|max:4096']);

        $path = $request->file('image')->store('campaigns', 'public');
        $image = $campaign->images()->create(['url' => asset('storage/' . $path)]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Image added to campaign gallery',
            'data'    => $image,
        ], 201);
    }

    /**
     * Search campaigns (public — only active).
     */
    public function search(Request $request)
    {
        $query = $request->input('q');

        if (!$query) {
            return response()->json(['data' => [], 'message' => 'Search query is required', 'status' => 400], 400);
        }

        $campaigns = Campaign::with(['images', 'category'])
            ->where('status', 'active')
            ->where(function ($q) use ($query) {
                $q->where('title', 'like', '%' . $query . '%')
                  ->orWhere('description', 'like', '%' . $query . '%');
            })->get();

        return response()->json(['data' => $campaigns, 'message' => 'Search results', 'status' => 200]);
    }

    /**
     * Filter campaigns (public — only active).
     */
    public function filter(Request $request)
    {
        $query = Campaign::with(['images', 'category'])->where('status', 'active');

        if ($request->has('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Filtered campaigns retrieved successfully',
            'data' => $query->get(),
        ]);
    }
}
