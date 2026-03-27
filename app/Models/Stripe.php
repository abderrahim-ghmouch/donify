<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stripe extends Model
{
    protected $fillable = [
        'user_id',
        'stripe_customer_id',
        'stripe_account_id',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
