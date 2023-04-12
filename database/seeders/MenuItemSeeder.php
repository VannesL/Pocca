<?php

namespace Database\Seeders;

use App\Models\MenuItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuItemSeeder extends Seeder
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
            'name' => 'Hamburger',
            'description' => 'Standard burger patty between 2 buns',
            'availability' => true,
            'price' => 10000,
            'cook_time' => 120,
            'image' => 'hamburger.png',
        ]);
    }
}
