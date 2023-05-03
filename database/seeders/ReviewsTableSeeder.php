<?php

namespace Database\Seeders;

use App\Models\Review;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReviewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Review::create([
            'order_id' => 4,
            'vendor_id' => 1,
            'date' => Carbon::now(),
            'rating' => 5,
            'description' => 'Enak banget rasanya <3 !!'
        ]);

        Review::create([
            'order_id' => 3,
            'vendor_id' => 1,
            'date' => Carbon::now(),
            'rating' => 3,
            'description' => 'Enak enak aja klo cuma pengen coba tapi yah ada harga ada rasa!!'
        ]);
    }
}
