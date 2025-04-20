<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product; // pastikan namespace modelnya bener

class ProductSeeder extends Seeder
{
    public function run()
    {
        Product::factory()->count(50)->create();
    }
}
