<?php

namespace Database\Seeders;

use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CustomerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Customer::create([
            'email' => 'customer@pocca.com',
            'password' => Hash::make('12345678'),
            'name' => 'Customer',
            'phone_number' => '0812345678',
            'dob' => Carbon::create(2002, 5, 19),
        ]);
    }
}
