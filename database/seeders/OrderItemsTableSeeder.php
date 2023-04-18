<?php

namespace Database\Seeders;

use App\Models\OrderItems;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OrderItems::create([
            'menu_id' => 1,
            'order_id' => 1,
            'quantity' => 1,
            'notes' => '',
        ]);

        OrderItems::create([
            'menu_id' => 2,
            'order_id' => 1,
            'quantity' => 1,
            'notes' => '',
        ]);
    }
}
