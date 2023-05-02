<?php

namespace Database\Seeders;

use App\Models\Vendor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
            'password' => Hash::make('12345678'),
            'name' => 'Vendor',
            'store_name' => 'Vendor Store',
            'phone_number' => '0812345678',
            'address' => 'Jalan Sana Sini Block 123',
            'description' => 'This is Canteen Pocca\'s first store',
            'favorites' => 0,
            'qris' => 'qris_pocca.jpg',
            'image' => 'Image',
        ]);

        Vendor::create([
            'canteen_id' => 1,
            'approved_by' => null,
            'range_id' => 1,
            'email' => 'booklet@pocca.com',
            'password' => Hash::make('12345678'),
            'name' => 'Brokey',
            'store_name' => 'Booklets Store',
            'phone_number' => '0812345678',
            'address' => 'Jalan Sana Sini Block 123',
            'description' => 'This is Canteen Pocca\'s first store',
            'favorites' => 0,
            'qris' => 'qris34394d3c8639448fe8d600da0caffe13.jpg',
            'image' => 'default.jpg',
        ]);
        Vendor::create([
            'canteen_id' => 2,
            'approved_by' => 1,
            'range_id' => 1,
            'email' => 'Hog@pocca.com',
            'password' => Hash::make('12345678'),
            'name' => 'Chains',
            'store_name' => 'Poggy Pork',
            'phone_number' => '0812345678',
            'address' => 'Jalan Sana Sini Block 123',
            'description' => 'This is Canteen Pocca\'s first store',
            'favorites' => 0,
            'qris' => 'QRIS',
            'image' => 'default.jpg',
        ]);

        Vendor::create([
            'canteen_id' => 2,
            'approved_by' => null,
            'range_id' => 1,
            'email' => 'Chick@pocca.com',
            'password' => Hash::make('12345678'),
            'name' => 'kiki',
            'store_name' => 'Gigantic Chikin',
            'phone_number' => '0812345678',
            'address' => 'Jalan Sana Sini Block 123',
            'description' => 'This is Canteen Pocca\'s first store',
            'favorites' => 0,
            'qris' => 'qris34394d3c8639448fe8d600da0caffe13.jpg',
            'image' => 'default.jpg',
        ]);
    }
}
