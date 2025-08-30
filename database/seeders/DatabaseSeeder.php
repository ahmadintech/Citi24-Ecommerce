<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(adminsTableSeeder::class);
        // $this->call(sectionsTableSeeder::class);
        // $this->call(categoryTableSeeder::class);
        // $this->call(productsTableSeeder::class);
        // $this->call(productAttributesTableSeeder::class);
        // $this->call(productsImagesTableSeeder::class);
    }
}