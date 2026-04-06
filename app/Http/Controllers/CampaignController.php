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

public function create(Request $request){

$validateData = $request->validate([
    'name' => 'required|string|max:255',
    'description' => 'nullable|string',
    'start_date' => 'required|date',
    'end_date' => 'required|date|after_or_equal:start_date',
]);

$campaign=Campaign::create($validateData);

return response()->json(['data'=>$campaign,'message'=>'Campaign created successfully','status'=>201],'201');

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
}

