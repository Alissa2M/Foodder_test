<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = Category::create([
            'color' => '緑',
            'category_name' => '朝',
        ]);
        $category = Category::create([
            'color' => '黄',
            'category_name' => '昼',
        ]);
        $category = Category::create([
            'color' => '青',
            'category_name' => '夜',
        ]);
        $category = Category::create([
            'color' => '紫',
            'category_name' => 'その他',
        ]);
    }
}
