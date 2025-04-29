<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            ['name' => 'Administrator'],
            ['name' => 'Pimpinan'],
            ['name' => 'Kasir'],
        ]);

        User::insert([
            [
                'name' => 'PPKD Pusat',
                'email' => 'pimpinan@gmail.com',
                'password' => Hash::make('12345678'),
                'role_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sandi',
                'email' => 'kasir@gmail.com',
                'password' => Hash::make('12345678'),
                'role_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
