<?php

namespace App\Models\Review;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'title',
        'product_name',
        'product_image_url',
        'reviewer',
        'content',
        'review_url',
        'reviewer_avatar_url',
        'user_id',
        'post_id',
        'rating',
        'status',
        'review_date',
    ];

    protected $appends = ['country'];

    public function getCountryAttribute()
    {
        $url = $this->review_url;

        if (strpos($url, '.sg') !== false) {
            return 'Singapore';
        } elseif (strpos($url, '.my') !== false) {
            return 'Malaysia';
        }

        return 'Unknown';
    }
}