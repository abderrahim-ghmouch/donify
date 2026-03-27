<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifcation extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'message',
        'type',
        'read_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
