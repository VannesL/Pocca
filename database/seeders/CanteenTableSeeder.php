<?php

namespace Database\Seeders;

use App\Models\Canteen;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CanteenTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Canteen::create([
            'approved_by' => 1,
            'name' => 'Canteen Pocca',
            'address' => 'Jalan Sana Sini Block 123',
            'favorites' => 0,
        ]);
    }
}
