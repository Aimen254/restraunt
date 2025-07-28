<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Appetizers', 'description' => 'Start your meal with our delicious appetizers'],
            ['name' => 'Main Courses', 'description' => 'Hearty and satisfying main dishes'],
            ['name' => 'Desserts', 'description' => 'Sweet endings to your meal'],
            ['name' => 'Drinks', 'description' => 'Refreshing beverages'],
            ['name' => 'Specials', 'description' => 'Chef\'s special creations'],
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => \Str::slug($category['name']),
                'description' => $category['description'],
                'is_active' => true,
            ]);
        }
    }
}