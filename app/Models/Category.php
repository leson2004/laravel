<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Cho phép mass assignment cho các cột này
    protected $fillable = [
        'name'
    ];
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
