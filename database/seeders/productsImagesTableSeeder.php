<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\productsImage;

class productsImagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productsImagesRecords = [
            [ 'id'=>1,'product_id'=>1,'image'=>'black t shirt.jpg-448.jpg','status'=>1 ],

            [ 'id'=>2,'product_id'=>2,'image'=>'green shirt.png-592.png','status'=>1 ],
        ];

        productsImage::insert($productsImagesRecords);
    }
}
