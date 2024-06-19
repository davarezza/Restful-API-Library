<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = [
            [
                'id' => Str::uuid(),
                'firstname' => 'Dava',
                'lastname' => 'Rezza',
                'username' => 'davarezz',
                'email' => 'davarezz@gmail.com',
                'password' => Hash::make('123'),
            ],
            [
                'id' => Str::uuid(),
                'firstname' => 'Admin',
                'lastname' => '1',
                'username' => 'admin',
                'email' => 'admin@gmail.com',
                'isadmin' => true,
                'password' => Hash::make('123'),
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
