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

public function store(Request $request){

$validateData = $request->validate([
    'name' => 'required|string|max:255',
    'description' => 'nullable|string',
    'start_date' => 'required|date',
    'end_date' => 'required|date|after_or_equal:start_date',
]);

$campaign=Campaign::create($validateData);

return response()->json(['data'=>$campaign,'message'=>'Campaign created successfully','status'=>201],'201');

}

public function show($id){

    $campaign = Campaign::findOrFail($id);

    return response()->json(['data' => $campaign, 'message' => 'Campaign retrieved successfully', 'status' => 200]);
}

public function update(Request $request, $id)
{
    $campaign = Campaign::findOrFail($id);

    $validatedData = $request->validate([
        'name' => 'sometimes|string|max:255',
        'description' => 'sometimes|nullable|string',
        'start_date' => 'sometimes|date',
        'end_date' => 'sometimes|date|after_or_equal:start_date',
    ]);

    $campaign->update($validatedData);

    return response()->json(['data' => $campaign, 'message' => 'Campaign updated successfully', 'status' => 200]);
}

public function destroy($id){

    $campaign = Campaign::findOrFail($id);

    $campaign->delete();

    return response()->json(['data' => $campaign, 'message' => 'Campaign deleted successfully', 'status' => 200]);
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

public function filter(Request $request){

    $query = Campaign::query();

    if ($request->has('start_date')) {
        $query->whereDate('start_date', '>=', $request->input('start_date'));
    }

    if ($request->has('end_date')) {
        $query->whereDate('end_date', '<=', $request->input('end_date'));
    }

    if ($request->has('name')) {
        $query->where('name', 'like', '%' . $request->input('name') . '%');
    }

    $campaigns = $query->get();

    return response()->json(['data' => $campaigns, 'message' => 'Filtered campaigns retrieved successfully', 'status' => 200]);
}
}

