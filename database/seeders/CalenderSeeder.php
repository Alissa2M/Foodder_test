<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Calender;

class CalenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $calender = Calender::create([
            'title' => 'お寿司',
            'description' => '1000円',
            'start' => '2023/03/03',
            'img_path' => null,
            'user_id' => '2',
            'category_id' => '3',
            'shop_name' => '縁',
            'good' => 3,
        ]);
        $calender = Calender::create([
            'title' => '海鮮丼',
            'description' => '札幌で食べた',
            'start' => '2023/03/03',
            'img_path' => null,
            'user_id' => '1',
            'category_id' => '3',
            'shop_name' => null,
            'good' => 10,
        ]);
        $calender = Calender::create([
            'title' => 'ピザ',
            'description' => '1000円',
            'start' => '2023/03/03',
            'img_path' => null,
            'user_id' => '1',
            'category_id' => '2',
            'shop_name' => 'ドミノピザ',
            'good' => 0,
        ]);
        $calender = Calender::create([
            'title' => '角煮',
            'description' => 'かうが作ってくれた角煮！',
            'start' => '2023/03/01',
            'img_path' => null,
            'user_id' => '1',
            'category_id' => '1',
            'shop_name' => null,
            'good' => 1,
        ]);
    }
}
