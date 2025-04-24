<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Role;
use App\Models\UserRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::insert([
            [
                'id' => 1,
                'category_name' => 'Makanan Berat',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'category_name' => 'Makanan Ringan',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'category_name' => 'Minuman Dingin',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'category_name' => 'Minuman Panas',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'category_name' => 'Dessert',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 6,
                'category_name' => 'Fast Food',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 7,
                'category_name' => 'Seafood',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 8,
                'category_name' => 'Asian Food',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 9,
                'category_name' => 'Western Food',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 10,
                'category_name' => 'Italian Food',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 11,
                'category_name' => 'Japanese Food',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 12,
                'category_name' => 'Korean Food',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 13,
                'category_name' => 'Traditional Indonesian Food',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        Role::insert([
            [
                'id' => 1,
                'name' => 'Administrator',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'Kasir',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'name' => 'Pimpinan',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        UserRole::insert([
            [
                'id' => 1,
                'user_id' => 1,
                'role_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'user_id' => 1,
                'role_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'user_id' => 1,
                'role_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
