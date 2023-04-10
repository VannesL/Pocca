<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\PriceRange;
use Illuminate\Database\Seeder;

class PriceRangeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PriceRange::create([
            'value' => 'Rp. 10k-50k',
            'min' => 10000,
            'max' => 50000,
        ]);
    }
}
