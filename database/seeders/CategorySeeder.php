<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Sweet',
                'description' => 'Aneka kue dan camilan manis yang lezat untuk menemani hari Anda.',
                'sort_order' => 1,
            ],
            [
                'name' => 'Savory',
                'description' => 'Pilihan camilan gurih dan asin yang cocok untuk semua selera.',
                'sort_order' => 2,
            ],
            [
                'name' => 'Donut',
                'description' => 'Donat lembut dengan berbagai topping dan isian yang menggugah selera.',
                'sort_order' => 3,
            ],
            [
                'name' => 'Traditional Cake Platter & Tray',
                'description' => 'Hidangan kue tradisional dalam platter dan tray untuk acara spesial Anda.',
                'sort_order' => 4,
            ],
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
                'sort_order' => $category['sort_order'],
                'is_active' => true,
            ]);
        }
    }
}
