<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $limit = 100;
        $data = [];

        for ($i = 0; $i < $limit; ++$i) {
            $data[] = [
                'name' => fake()->name(),
                'email' => fake()->email(),
                'password' => Hash::make('password'),
                'created_at' => now()->toDateTimeString(),
                'updated_at' => now()->toDateTimeString(),
            ];
        }

        DB::table('users')->insert($data);
    }
}
