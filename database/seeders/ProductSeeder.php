<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Tạo category mẫu
        $category = Category::create([
            'name' => 'Kính râm thời trang'
        ]);

        // Tạo 5 sản phẩm mẫu
        Product::create([
            'name'           => 'Kính râm Gucci GG0061S',
            'description'    => 'Kính râm cao cấp với gọng nhựa và tròng chống UV.',
            'quantity'       => 10,
            'price'          => 3500000,
            'frame_material' => 'Nhựa cao cấp',
            'lens_color'     => 'Đen',
            'lens_material'  => 'Polycarbonate',
            'brand'          => 'Gucci',
            'weight'         => 35,
            'category_id'    => $category->id
        ]);

        Product::create([
            'name'           => 'Kính râm Ray-Ban RB3025',
            'description'    => 'Thiết kế phi công cổ điển với tròng chống tia UV400.',
            'quantity'       => 20,
            'price'          => 2800000,
            'frame_material' => 'Kim loại',
            'lens_color'     => 'Xanh rêu',
            'lens_material'  => 'Kính',
            'brand'          => 'Ray-Ban',
            'weight'         => 30,
            'category_id'    => $category->id
        ]);
    }
}

