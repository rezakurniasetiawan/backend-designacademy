<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $datas = [
            [
                'name' => 'Reza Kurnia Setiawan',
                'username' => 'rezakurniasetiawan',
                'password' => bcrypt('password'),
                'role' => 'administrator',
            ],
            [
                'name' => 'Havina',
                'username' => 'havina',
                'password' => bcrypt('password'),
                'role' => 'teacher',
            ],
            [
                'name' => 'User',
                'username' => 'user',
                'password' => bcrypt('password'),
                'role' => 'student',
            ],
        ];

        foreach ($datas as $data) {
            User::factory()->create([
                'name' => $data['name'],
                'username' => $data['username'],
                'password' => $data['password'],
                'role' => $data['role'],
            ]);
        }
    }
}
