<?php

namespace Database\Seeders;

use App\Models\Vendor;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VendorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Vendor::create([
            'canteen_id' => 1,
            'approved_by' => 1,
            'range_id' => 1,
            'email' => 'vendor@pocca.com',
            'password' => '12345678',
            'name' => 'Vendor',
            'store_name' => 'Vendor Store',
            'phone_number' => '0812345678',
            'address' => 'Jalan Sana Sini Block 123',
            'description' => 'This is Canteen Pocca\'s first store',
            'favorites' => 0,
            'qris' => 'QRIS',
            'image' => 'Image',
        ]);
    }
}
