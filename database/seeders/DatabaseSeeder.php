<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            AdminTableSeeder::class,
            PriceRangeTableSeeder::class,
            CanteenTableSeeder::class,
            CustomerTableSeeder::class,
            VendorTableSeeder::class,
            CategoryTableSeeder::class,
            MenuItemTableSeeder::class,
            StatusTableSeeder::class,
            OrderTableSeeder::class,
            OrderItemsTableSeeder::class,
            ReviewsTableSeeder::class
        ]);
    }
}
