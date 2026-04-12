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

    $campaigns = Campaign::where('name', 'like', '%' . $query . '%')
        ->orWhere('description', 'like', '%' . $query . '%')
        ->get();

    return response()->json(['data' => $campaigns, 'message' => 'Search results retrieved successfully', 'status' => 200]);
}

    public function filter(Request $request)
    {
        

        if ($request->has('category_id')) {
            $campaigns = Campaign::where('category_id', $request->input('category_id'))->get();
        }



        return response()->json([
            'status' => 'success',
            'message' => 'Filtered campaigns retrieved successfully',
            'data' => $campaigns
        ]);
    }
}
