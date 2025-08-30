<?php

namespace Database\Seeders;

use App\Models\product;
use Illuminate\Database\Seeder;

class productsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $productRecord = [
        //     [
        //         'id' => 1, 'category_id' => 2, 'section_id' => 1, 'product_name' => 'Blue casual T-shirt', 'product_code' => 'BT001', 'product_color' => 'blue',
        //         'price' => 1500, 'product_discount' => 10, 'product_weight' => 200, 'product_video' => '', 'main_image' => '', 'description' => 'Test product',
        //         'wash_care' => '', 'fabric' => '', 'sleeve' => '', 'fit' => '', 'occasion' => '', 'meta_title' => '', 'meta_description' => '', 'meta_keywords' => '',
        //         'is_featured' => 'No', 'status' => 1
        //     ],

        //     [
        //         'id' => 2, 'category_id' => 2, 'section_id' => 1, 'product_name' => 'Red Casual T-shirt', 'product_code' => 'R001', 'product_color' => 'red',
        //         'price' => 2400, 'product_discount' => 10, 'product_weight' => 200, 'product_video' => '', 'main_image' => '', 'description' => 'Test product',
        //         'wash_care' => '', 'fabric' => '', 'sleeve' => '', 'fit' => '', 'occasion' => '', 'meta_title' => '', 'meta_description' => '', 'meta_keywords' => '',
        //         'is_featured' => 'Yes', 'status' => 1
        //     ]
        // ];
        $productRecord = [
            [
                'id' => 1, 'category_id' => 2,  'product_name' => 'Blue casual T-shirt',   'price' => 1500, 'product_discount' => 10, 'product_weight' => 200, 'main_image' => '', 'description' => 'Test product',
                'is_featured' => 'No', 'status' => 1, 'quantity' => 5,
            ],

            [
                'id' => 2, 'category_id' => 2,  'product_name' => 'Red  Casual T-shirt', 'price' => 2400, 'product_discount' => 10, 'product_weight' => 200, 'main_image' => '', 'description' => 'Test product',
                'is_featured' => 'Yes', 'status' => 1, 'quantity' => 10,
            ],
            [
                'id' => 3, 'category_id' => 3,  'product_name' => 'Potato',   'price' => 1500, 'product_discount' => 10, 'product_weight' => 200, 'main_image' => '', 'description' => 'Test product',
                'is_featured' => 'No', 'status' => 1, 'quantity' => 5,
            ],

            [
                'id' => 4, 'category_id' => 4,  'product_name' => 'Rice', 'price' => 2400, 'product_discount' => 10, 'product_weight' => 200, 'main_image' => '', 'description' => 'Test product',
                'is_featured' => 'Yes', 'status' => 1, 'quantity' => 10,
            ],
            [
                'id' => 5, 'category_id' => 5,  'product_name' => 'Plantain',   'price' => 1500, 'product_discount' => 10, 'product_weight' => 200, 'main_image' => '', 'description' => 'Test product',
                'is_featured' => 'No', 'status' => 1, 'quantity' => 5,
            ],

            [
                'id' => 6, 'category_id' => 6,  'product_name' => 'Beans', 'price' => 2400, 'product_discount' => 10, 'product_weight' => 200, 'main_image' => '', 'description' => 'Test product',
                'is_featured' => 'Yes', 'status' => 1, 'quantity' => 10,
            ]
        ];
        product::insert($productRecord);
    }
}
