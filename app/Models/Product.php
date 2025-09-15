<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Cho phép gán hàng loạt các trường này
    protected $fillable = [
        'name',
        'description',
        'quantity',
        'price',
        'frame_material',
        'lens_color',
        'lens_material',
        'brand',
        'weight',
        'category_id',
        'image_url'
    ];

    // Quan hệ 1-1: Mỗi sản phẩm thuộc về 1 category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
