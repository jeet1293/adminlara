<?php

namespace App\Http\Resources;

use App\Model\Category;
use App\Model\ProductImage;
use Illuminate\Http\Resources\Json\JsonResource;

class Product extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'category' => Category::whereIn('id', $this->category_id)->get(['id', 'title', 'slug'])->toArray(),
            'title' => $this->title,
            'slug' => $this->slug,
            'image' => !empty($this->image) ? asset('uploads/products').'/'.$this->image : null,
            'description' => $this->description,
            'created_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at,
            'gallery' => ProductImage::where('product_id', $this->id)->get(['id', 'image', 'name'])->toArray(),
        ];
    }
}
