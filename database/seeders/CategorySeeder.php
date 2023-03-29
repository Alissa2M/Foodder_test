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
            'color' => 'green',
            'category_name' => '朝',
        ]);
        $category = Category::create([
            'color' => 'yellow',
            'category_name' => '昼',
        ]);
        $category = Category::create([
            'color' => 'blue',
            'category_name' => '夜',
        ]);
        $category = Category::create([
            'color' => 'purple',
            'category_name' => 'その他',
        ]);
    }
}
