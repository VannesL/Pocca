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
            'value' => 'Rp. <50k',
            'min' => 0,
            'max' => 50000,
        ]);

        PriceRange::create([
            'value' => 'Rp. 50k-70k',
            'min' => 50000,
            'max' => 70000,
        ]);

        PriceRange::create([
            'value' => 'Rp. 70k-100k',
            'min' => 70000,
            'max' => 100000,
        ]);

        PriceRange::create([
            'value' => 'Rp. >100k',
            'min' => 100000,
            'max' => 0,
        ]);
    }
}
