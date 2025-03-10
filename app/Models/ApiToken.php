<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class ApiToken extends Model
{
    use HasUuids;

    protected $fillable = [
        'user_id',
    ];

    // protected $hidden = [
    //     'token',
    // ];
}
