<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Campaign extends Model
{

    protected $fillable = [
        'user_id',
        'category_id',
        'organisation_id',
        'title',
        'description',
        'target_amount',
        'current_amount',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function organisation()
    {
        return $this->belongsTo(Organisation::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function favourites()
    {
        return $this->hasMany(Favourite::class);
    }
}
