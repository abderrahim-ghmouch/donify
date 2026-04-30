<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Favourite;

class FavouriteController extends Controller
{
    /**
     * Display a listing of user's favourites.
     */
    public function index()
    {
        $favourites = auth('api')->user()
            ->favourites()
            ->with(['campaign.images', 'campaign.category', 'campaign.user'])
            ->latest()
            ->get();

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
        $userId = auth('api')->id();

        $favouriteQuery = Favourite::where('user_id', $userId)
            ->where('campaign_id', $campaign->id);

        if ($favouriteQuery->exists()) {
            $favouriteQuery->delete();
            return response()->json([
                'status'     => 'success',
                'message'    => 'Removed from favourites',
                'favourited' => false,
            ]);
        }

        Favourite::firstOrCreate([
            'user_id'     => $userId,
            'campaign_id' => $campaign->id
        ]);

        return response()->json([
            'status'     => 'success',
            'message'    => 'Added to favourites',
            'favourited' => true,
        ], 201);
    }
}
