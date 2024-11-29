<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Felipe',
                'email' => 'felipe@convenia.com',
                'password' => Hash::make('password')
            ],
            [
                'name' => 'João',
                'email' => 'joao@convenia.com',
                'password' => Hash::make('password')
            ],
            [
                'name' => 'Pedro',
                'email' => 'pedro@convenia.com',
                'password' => Hash::make('password')
            ],
            [
                'name' => 'Marcelo',
                'email' => 'marcelo@convenia.com',
                'password' => Hash::make('password')
            ],
        ];

        foreach ($users as $user) {
            $existUser = User::where('email', $user['email'])->first();

            if (!$existUser) {
                User::create($user);
            } else {
                $existUser->update($user);
            }
        }
    }
}
