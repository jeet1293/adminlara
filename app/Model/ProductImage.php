<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{

    public $table = 'product_images';
    
    public $timestamps = false;

    protected $fillable = [
        'product_id', 'name', 'image'
    ];
}
