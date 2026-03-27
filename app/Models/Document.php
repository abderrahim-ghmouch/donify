<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'campaign_id',
        'url',
        'title',
        'type'
    ];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
}
