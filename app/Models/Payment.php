<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'user_id',
        'donation_id',
        'payment_method',
        'amount',
        'currency',
        'status',
        'transaction_id',
        'reference_id',
        'provider_data',
        'response_message'
    ];

    protected $casts = [
        'provider_data' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function donation()
    {
        return $this->belongsTo(Donation::class);
    }
}
