<?php

namespace Database\Seeders;

use App\Http\Controllers\SalesController;
use App\Models\Bill;
use App\Models\User;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call([
            CategorySeeder::class,

            ProductSeeder::class,
            UseSeeder::class,
            regSeeder::class
        ]);
    }
}
