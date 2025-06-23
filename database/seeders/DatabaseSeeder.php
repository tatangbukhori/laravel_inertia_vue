<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'avatar' => 'avatars/eCwQMLj5lJihDW8iZLo9IE0GMrN8pk0ta5UKk2Yw.png',
            'name' => 'Tatang Bukhori',
            'email' => 'tatangb909@gmail.com',
            'role' => 'Admin',
            'password' => bcrypt('password')
        ]);

        User::factory(30)->create();
    }
}
