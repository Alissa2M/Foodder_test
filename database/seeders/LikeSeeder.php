<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Like;

class LikeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $like = Like::create([
            'calender_id' => '1',
            'user_id' => '1',
        ]);
        $like = Like::create([
            'calender_id' => '1',
            'user_id' => '2',
        ]);
        $like = Like::create([
            'calender_id' => '1',
            'user_id' => '3',
        ]);
        $like = Like::create([
            'calender_id' => '2',
            'user_id' => '1',
        ]);
        $like = Like::create([
            'calender_id' => '4',
            'user_id' => '2',
        ]);
        $like = Like::create([
            'calender_id' => '4',
            'user_id' => '3',
        ]);
    }
}
