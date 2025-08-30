<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShippingPricesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $states = [
            ['name' => 'Abia', 'price' => 4000],
            ['name' => 'Adamawa', 'price' => 4000],
            ['name' => 'Akwa Ibom', 'price' => 4000],
            ['name' => 'Anambra', 'price' => 4000],
            ['name' => 'Bauchi', 'price' => 4000],
            ['name' => 'Bayelsa', 'price' => 4000],
            ['name' => 'Benue', 'price' => 4000],
            ['name' => 'Borno', 'price' => 4000],
            ['name' => 'Cross River', 'price' => 4000],
            ['name' => 'Delta', 'price' => 4000],
            ['name' => 'Ebonyi', 'price' => 4000],
            ['name' => 'Edo', 'price' => 4000],
            ['name' => 'Ekiti', 'price' => 4000],
            ['name' => 'Enugu', 'price' => 4000],
            ['name' => 'Gombe', 'price' => 4000],
            ['name' => 'Imo', 'price' => 4000],
            ['name' => 'Jigawa', 'price' => 4000],
            ['name' => 'Kaduna', 'price' => 4000],
            ['name' => 'Kano', 'price' => 4000],
            ['name' => 'Katsina', 'price' => 4000],
            ['name' => 'Kebbi', 'price' => 4000],
            ['name' => 'Kogi', 'price' => 4000],
            ['name' => 'Kwara', 'price' => 4000],
            ['name' => 'Lagos', 'price' => 4000],
            ['name' => 'Nasarawa', 'price' => 4000],
            ['name' => 'Niger', 'price' => 4000],
            ['name' => 'Ogun', 'price' => 4000],
            ['name' => 'Ondo', 'price' => 4000],
            ['name' => 'Osun', 'price' => 4000],
            ['name' => 'Oyo', 'price' => 4000],
            ['name' => 'Plateau', 'price' => 4000],
            ['name' => 'Rivers', 'price' => 4000],
            ['name' => 'Sokoto', 'price' => 4000],
            ['name' => 'Taraba', 'price' => 4000],
            ['name' => 'Yobe', 'price' => 4000],
            ['name' => 'Zamfara', 'price' => 4000],
        ];

        // Insert data into the 'shipping_prices' table
        foreach ($states as $state) {
            DB::table('shipping_prices')->insert([
                'state' => $state['name'],
                'price' => $state['price'],
            ]);

    }

}
}
