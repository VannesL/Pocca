<?php

namespace Database\Seeders;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Order::create([
            'customer_id' => 1,
            'vendor_id' => 1,
            'status_id' => 1,
            'total' => 16000,
            'type' => true,
            'date' => Carbon::now(),
            'reviewed' => false,
            'payment_image' => '',
        ]);

        Order::create([
            'customer_id' => 1,
            'vendor_id' => 1,
            'status_id' => 1,
            'total' => 16000,
            'type' => true,
            'date' => Carbon::now(),
            'reviewed' => false,
            'payment_image' => '',
        ]);
    }
}
