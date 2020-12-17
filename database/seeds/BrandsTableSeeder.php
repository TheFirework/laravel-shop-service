<?php

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandsTableSeeder extends Seeder
{
    public function run()
    {
        $created_at = date('Y-m-d H:i:s');
        $updated_at = date('Y-m-d H:i:s');
        $brands = [
            [
                'name' => 'Apple',
                'cover' => '/uploads/images/default/brands/apple.jpg',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'name' => '华为（HUAWEI）',
                'cover' => '/uploads/images/default/brands/huawei.jpg',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'name' => '荣耀（honor）',
                'cover' => '/uploads/images/default/brands/honor.jpg',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'name' => '小米（MI）',
                'cover' => '/uploads/images/default/brands/xiaomi.jpg',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'name' => 'vivo',
                'cover' => '/uploads/images/default/brands/vivo.jpg',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'name' => 'OPPO',
                'cover' => '/uploads/images/default/brands/oppo.jpg',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
            [
                'name' => '锤子（smartisan）',
                'cover' => '/uploads/images/default/brands/cuizi.jpg',
                'created_at' => $created_at,
                'updated_at' => $updated_at
            ],
        ];

        Brand::insert($brands);
    }
}
