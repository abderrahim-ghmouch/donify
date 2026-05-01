<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payout extends Model
{
    protected $fillable = [
        'user_id',
        'campaign_id',
        'amount',
        'currency',
        'status',
        'stripe_transfer_id',
        'provider_data',
        'failure_message',
    ];

    protected $casts = [
        'provider_data' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
}
