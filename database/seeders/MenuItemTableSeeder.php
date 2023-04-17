<?php

namespace Database\Seeders;

use App\Models\MenuItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuItemTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MenuItem::create([
            'vendor_id' => '1',
            'category_id' => '1',
            'name' => '1_Hamburger',
            'description' => 'Standard burger patty between 2 buns',
            'availability' => true,
            'price' => 10000,
            'cook_time' => 5,
            'image' => 'hamburger.png',
        ]);

        MenuItem::create([
            'vendor_id' => '1',
            'category_id' => '1',
            'name' => '1_Cheese French Fries',
            'description' => 'Fresh fries seasoned with salt topped with our cheese topping',
            'availability' => true,
            'price' => 6000,
            'cook_time' => 2,
            'image' => 'fries.png',
        ]);

        MenuItem::create([
            'vendor_id' => '1',
            'category_id' => '2',
            'name' => '1_Soda',
            'description' => 'Standard soda',
            'availability' => true,
            'price' => 3000,
            'cook_time' => 1,
            'image' => 'soda.png',
        ]);
    }
}
