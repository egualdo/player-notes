<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $manage = [[
            'name' => 'root',
            'email' => "root@email.com",
            'email_verified_at' => now(),
            'password' => Hash::make('root'),
            'remember_token' => Str::random(10),
        ], [
            'name' => 'support',
            'email' => "support@email.com",
            'email_verified_at' => now(),
            'password' =>  Hash::make('support'),
            'remember_token' => Str::random(10),
        ]];

        foreach ($manage as  $value) {
            User::create($value);
        }
    }
}
