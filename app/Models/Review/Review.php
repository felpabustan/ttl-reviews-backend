<?php

namespace App\Models\Review;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'title',
        'product_name',
        'reviewer',
        'content',
        'review_url',
        'reviewer_avatar_url',
        'rating',
        'status',
        'review_date',
    ];
}