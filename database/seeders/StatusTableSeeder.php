<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Processing (waiting for customer payment)
        // In Payment (customer sent payment proof)
        // Cooking (vendor making order)
        // Ready (food ready to be taken by customer)
        // Complete (food taken by customer, order finished) 

        Status::create([
            'name' => 'Processing',
            'description' => 'Waiting for vendor to confirm the order.',
        ]);

        Status::create([
            'name' => 'In Payment',
            'description' => 'Waiting for customer to pay OR vendor to approve payment.',
        ]);

        Status::create([
            'name' => 'Cooking',
            'description' => 'Vendor is currently making the order.',
        ]);

        Status::create([
            'name' => 'Ready',
            'description' => 'Order is ready to be taken by customer.',
        ]);

        Status::create([
            'name' => 'Complete',
            'description' => 'Customer picked up the order. The order is completed.',
        ]);

        Status::create([
            'name' => 'Rejected',
            'description' => 'Vendor has rejected the order.',
        ]);
    }
}
