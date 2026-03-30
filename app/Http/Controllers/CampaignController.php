<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CampaignController extends Controller
{


public function create(request $request){

$validated=$request->validate([
    'title'=>'required|string|max:255',
    'description'=>'required|string',
    'goal_amount'=>'required|numeric|min:0',
    'end_date'=>'required|date|after:today',
]);

return response()->json(['message'=>'Campaign created successfully','data'=>$validated],201);


}
}
