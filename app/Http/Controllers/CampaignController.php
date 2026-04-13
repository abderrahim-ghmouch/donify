<?php

namespace App\Http\Controllers;
use App\Models\Campaign;
use Illuminate\Http\Request;

class CampaignController extends Controller
{


public function index(){

$campaigns =Campaign::all();

return response()->json(['data'=>$campaigns,'message'=>'Campaigns retrieved successfully','status'=>200]);
}

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'target_amount' => 'required|numeric|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        // Automatically assign the authenticated user
        $validateData['user_id'] = auth()->id();

        $campaign = Campaign::create($validateData);

        return response()->json([
            'status' => 'success',
            'message' => 'Campaign created successfully',
            'data' => $campaign
        ], 201);
    }

public function show($id){

    $campaign = Campaign::findOrFail($id);

    return response()->json(['data' => $campaign, 'message' => 'Campaign retrieved successfully', 'status' => 200]);
}

    public function update(Request $request, $id)
    {
        $campaign = Campaign::findOrFail($id);

        // Ownership Check: Only owner or admin can update
        if ($campaign->user_id !== auth()->id() && auth()->user()->role !== 'admin') {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized. You do not own this campaign.'
            ], 403);
        }

        $validatedData = $request->validate([
            'category_id' => 'sometimes|exists:categories,id',
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'target_amount' => 'sometimes|numeric|min:1',
            'start_date' => 'sometimes|date',
            'end_date' => 'sometimes|date|after_or_equal:start_date',
            'status' => 'sometimes|in:active,completed,cancelled'
        ]);

        $campaign->update($validatedData);

        return response()->json([
            'status' => 'success',
            'message' => 'Campaign updated successfully',
            'data' => $campaign
        ]);
    }

    public function destroy($id)
    {
        $campaign = Campaign::findOrFail($id);

        // Ownership Check
        if ($campaign->user_id !== auth()->id() && auth()->user()->role !== 'admin') {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized. You do not own this campaign.'
            ], 403);
        }

        $campaign->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Campaign deleted successfully'
        ]);
    }

public function search(Request $request){

    $query = $request->input('q');

    if (!$query) {
        return response()->json(['data' => [], 'message' => 'Search query is required', 'status' => 400], 400);
    }

    $campaigns = Campaign::where('title', 'like', '%' . $query . '%')
        ->orWhere('description', 'like', '%' . $query . '%')
        ->get();

    return response()->json(['data' => $campaigns, 'message' => 'Search results retrieved successfully', 'status' => 200]);
}

    public function filter(Request $request)
    {
        $query = Campaign::query();

        if ($request->has('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        $campaigns = $query->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Filtered campaigns retrieved successfully',
            'data' => $campaigns
        ]);
    }

    /**
     * Upload image to campaign gallery
     */
    public function uploadImage(Request $request, $id)
    {
        $campaign = Campaign::findOrFail($id);

        // Security
        if ($campaign->user_id !== auth()->id() && auth()->user()->role !== 'admin') {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized. You do not own this campaign.'
            ], 403);
        }

        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $path = $request->file('image')->store('campaigns', 'public');

        $image = $campaign->images()->create([
            'url' => asset('storage/' . $path)
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Image added to campaign gallery',
            'data' => $image
        ], 201);
    }
}
