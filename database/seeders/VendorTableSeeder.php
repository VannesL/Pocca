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
            'image' => 'profile39284aad0608b86513eebcf0496e659f.jpg',
            'avg_rating' => 4.0,
        ]);

        Vendor::create([
            'canteen_id' => 1,
            'approved_by' => null,
            'range_id' => null,
            'email' => 'booklet@pocca.com',
            'password' => Hash::make('12345678'),
            'name' => 'Brokey',
            'store_name' => 'Booklets Store',
            'phone_number' => '0812345678',
            'address' => 'Jalan Sana Sini Block 123',
            'description' => 'This is Canteen Pocca\'s first store',
            'favorites' => 0,
            'qris' => 'qris31ab37e822f2da59cb08667bf42b0784.jpg',
            'image' => 'default.jpg',
        ]);
        Vendor::create([
            'canteen_id' => 2,
            'approved_by' => 1,
            'range_id' => null,
            'email' => 'Hog@pocca.com',
            'password' => Hash::make('12345678'),
            'name' => 'Chains',
            'store_name' => 'Poggy Pork',
            'phone_number' => '0812345678',
            'address' => 'Jalan Sana Sini Block 123',
            'description' => 'This is Canteen Pocca\'s first store',
            'favorites' => 0,
            'qris' => 'qris39284aad0608b86513eebcf0496e659f.jpg',
            'image' => 'profile4ff0f8e8ad3ec8a1b4ee3eda33b46510.webp',
        ]);

        Vendor::create([
            'canteen_id' => 2,
            'approved_by' => null,
            'range_id' => null,
            'email' => 'Chick@pocca.com',
            'password' => Hash::make('12345678'),
            'name' => 'kiki',
            'store_name' => 'Gigantic Chikin',
            'phone_number' => '0812345678',
            'address' => 'Jalan Sana Sini Block 123',
            'description' => 'This is Canteen Pocca\'s first store',
            'favorites' => 0,
            'qris' => 'qris3abe90023534b46079b0de1a698a27d4.jpg',
            'image' => 'profile3abe90023534b46079b0de1a698a27d4.jpg',
        ]);
    }
}
