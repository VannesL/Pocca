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
            'rejection_reason' => '',
        ]);

        Order::create([
            'customer_id' => 1,
            'vendor_id' => 1,
            'status_id' => 3,
            'total' => 6000,
            'type' => true,
            'date' => Carbon::now(),
            'reviewed' => false,
            'payment_image' => 'default.png',
            'rejection_reason' => '',
        ]);

        Order::create([
            'customer_id' => 1,
            'vendor_id' => 1,
            'status_id' => 5,
            'total' => 9000,
            'type' => true,
            'date' => Carbon::now(),
            'reviewed' => false,
            'payment_image' => 'default.png',
            'rejection_reason' => '',
        ]);

        Order::create([
            'customer_id' => 1,
            'vendor_id' => 1,
            'status_id' => 5,
            'total' => 300000,
            'type' => true,
            'date' => Carbon::now()->subMonth(1),
            'reviewed' => false,
            'payment_image' => '',
            'rejection_reason' => '',
        ]);
    }
}
