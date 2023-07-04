<?php

namespace Database\Seeders;

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
        $categories = [
            ['name' => '勉強'],
            ['name' => '運動'],
            ['name' => '睡眠'],
            ['name' => '健康'],
            ['name' => '食事'],
            // 他のカテゴリーデータを追加する場合はここに追記
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
