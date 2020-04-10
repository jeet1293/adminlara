<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id', 'title', 'slug', 'status', 'image', 'description'
    ];

    protected $casts = [
        'category_id' => 'json'
    ]; 
}
