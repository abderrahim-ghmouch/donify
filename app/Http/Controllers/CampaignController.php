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
public function update (Request )

}
