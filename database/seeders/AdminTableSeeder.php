<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            'email' => 'admin@pocca.com',
            'password' => '123456789',
            'name' => 'Admin',
            'phone_number' => '085216428888',
        ]);
    }
}
