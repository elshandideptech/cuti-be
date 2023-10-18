<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

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
        \App\Models\User::create([
            'first_name' => 'Admin',
            'last_name' => 'Dummy',
            'email' => 'firstadmin@gmail.com',
            'password' => Hash::make('Rahasia123'),
        ]);
        DB::table('languages')->insert([
            'language' => 'Indonesia',
            'code' => 'id'
        ]);
        DB::table('languages')->insert([
            'language' => 'English',
            'code' => 'en'
        ]);
    }
}
