<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Favourite;
use Illuminate\Http\Request;

class FavouriteController extends Controller
{
    /**
     * Display a listing of user's favourites.
     */
    public function index()
    {
        $favourites = auth()->user()->favourites()->with('campaign.category')->get();

        return response()->json([
            'status' => 'success',
            'data'   => $favourites
        ]);
    }

    /**
     * Toggle a campaign as favourite.
     */
    public function toggle(Campaign $campaign)
    {
        $favourite = Favourite::where('user_id', auth()->id())
            ->where('campaign_id', $campaign->id)
            ->first();

        if ($favourite) {
            $favourite->delete();
            return response()->json([
                'status'  => 'success',
                'message' => 'Removed from favourites'
            ]);
        }

        Favourite::create([
            'user_id'     => auth()->id(),
            'campaign_id' => $campaign->id
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Added to favourites'
        ], 201);
    }
}
