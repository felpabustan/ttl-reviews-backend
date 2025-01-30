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
}