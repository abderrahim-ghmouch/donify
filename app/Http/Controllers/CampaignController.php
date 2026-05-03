<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Donation;
use App\Models\Payout;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    /**
     * Public listing (read-only, no auth required)
     * Only show active campaigns to the public.
     */
    public function index()
    {
        $campaigns = Campaign::with(['images', 'category', 'user'])
            ->where('status', 'active')
            ->latest()
            ->get();
        return response()->json(['data' => $campaigns, 'message' => 'Campaigns retrieved successfully', 'status' => 200]);
    }

    
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'category_id'   => 'required|exists:categories,id',
            'title'         => 'required|string|max:255',
            'description'   => 'required|string',
            'target_amount' => 'required|numeric|min:1',
            'start_date'    => 'nullable|date',
            'end_date'      => 'nullable|date|after_or_equal:start_date',
            'images'        => 'nullable|array',
            'images.*'      => 'image|mimes:jpeg,png,jpg,gif,webp|max:4096',
        ]);

        if (auth('organisation')->check()) {
            $validateData['organisation_id'] = auth('organisation')->id();
            $validateData['user_id'] = null;
        } else {
            // Check if normal porter already has a campaign
            $existingCampaign = Campaign::where('user_id', auth('api')->id())->first();
            if ($existingCampaign) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'You can only create one campaign. Please delete your existing campaign to create a new one.',
                ], 403);
            }

            $validateData['user_id'] = auth('api')->id();
            $validateData['organisation_id'] = null;
        }

        $validateData['status']  = 'pending';

        $campaign = Campaign::create($validateData);

        // Handle multiple mission assets
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('campaigns', 'public');
                $campaign->images()->create(['url' => asset('storage/' . $path)]);
            }
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Mission submitted for review with gallery assets.',
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
        $query = Campaign::with(['images', 'category'])
            ->withCount('donations')
            ->latest();

        if (auth('organisation')->check()) {
            $query->where('organisation_id', auth('organisation')->id());
        } else {
            $query->where('user_id', auth('api')->id());
        }

        $campaigns = $query->get();
        $campaigns->each(function ($campaign) {
            $completedDonations = (float) Donation::where('campaign_id', $campaign->id)
                ->where('status', 'completed')
                ->sum('amount');

            $reservedPayouts = (float) Payout::where('campaign_id', $campaign->id)
                ->whereIn('status', ['pending', 'processing', 'completed'])
                ->sum('amount');

            $campaign->available_for_payout = round($completedDonations - $reservedPayouts, 2);
        });

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
     * Admin: list ALL campaigns (all statuses).
     */
    public function all()
    {
        $campaigns = Campaign::with(['images', 'category', 'user'])
            ->latest()
            ->get();

        return response()->json([
            'status' => 'success',
            'data'   => $campaigns,
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

        $isOwner = false;
        if (auth('organisation')->check()) {
            $isOwner = $campaign->organisation_id === auth('organisation')->id();
        } else {
            $isOwner = $campaign->user_id === auth('api')->id();
        }

        if (!$isOwner && auth('api')->user()?->role !== 'admin') {
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

        $isOwner = false;
        if (auth('organisation')->check()) {
            $isOwner = $campaign->organisation_id === auth('organisation')->id();
        } else {
            $isOwner = $campaign->user_id === auth('api')->id();
        }

        if (!$isOwner && auth('api')->user()?->role !== 'admin') {
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

        $isOwner = false;
        if (auth('organisation')->check()) {
            $isOwner = $campaign->organisation_id === auth('organisation')->id();
        } else {
            $isOwner = $campaign->user_id === auth('api')->id();
        }

        if (!$isOwner && auth('api')->user()?->role !== 'admin') {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized.'], 403);
        }

        $request->validate(['image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:4096']);

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
