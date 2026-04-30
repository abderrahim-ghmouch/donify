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
        'status',
        'start_date',
        'end_date',
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
        return $this->morphMany(Image::class, 'imageable');
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }




    public function favourites()
    {
        return $this->hasMany(Favourite::class);
    }
}
