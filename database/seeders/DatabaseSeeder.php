<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\Category;
use Database\Seeders\Calender;
use Database\Seeders\Like;
use Database\Seeders\User;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        // $this->call(UserSeeder::class);
        $this->call(CategorySeeder::class);
        // $this->call(CalenderSeeder::class);
        // $this->call(LikeSeeder::class);

    }
}
