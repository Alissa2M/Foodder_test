<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'ありさ',
            'email'=> 'ario.96neko.0221@gmail.com',
            'email_verified_at'=> '2023-03-18 10:00',
            'password'=> 'password12345',
            'user_icon'=> NULL,
            'user_header'=> NULL,
        ]);
        $user = User::create([
            'name' => 'test2',
            'email'=> 'test2@example.com',
            'email_verified_at'=> '2023-03-18 10:00',
            'password'=> 'password12345',
            'user_icon'=> NULL,
            'user_header'=> NULL,
        ]);
        $user = User::create([
            'name' => 'test3',
            'email'=> 'test3@example.com',
            'email_verified_at'=> '2023-03-18 10:00',
            'password'=> 'password12345',
            'user_icon'=> NULL,
            'user_header'=> NULL,
        ]);

    }
}
