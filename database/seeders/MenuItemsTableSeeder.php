<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\MenuItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class MenuItemsTableSeeder extends Seeder
{
    public function run()
    {

        $menuItems = [
            // Appetizers
            [
                'category' => 'Appetizers',
                'name' => 'Bruschetta',
                'description' => 'Toasted bread topped with tomatoes, garlic, and fresh basil',
                'price' => 8.99,
                'prep_time' => 10,
                'image' => 'menu-items/bruschetta.jpg'
            ],
            [
                'category' => 'Appetizers',
                'name' => 'Calamari',
                'description' => 'Fried squid served with marinara sauce',
                'price' => 12.99,
                'prep_time' => 15,
                'image' => 'menu-items/calamari.jpg'
            ],
            // Main Courses
            [
                'category' => 'Main Courses',
                'name' => 'Spaghetti Carbonara',
                'description' => 'Classic pasta with eggs, cheese, pancetta, and pepper',
                'price' => 16.99,
                'prep_time' => 20,
                'image' => 'menu-items/spaghetti.jpg'
            ],
            [
                'category' => 'Main Courses',
                'name' => 'Grilled Salmon',
                'description' => 'Fresh salmon fillet with lemon butter sauce',
                'price' => 22.99,
                'prep_time' => 25,
                'image' => 'menu-items/salmon.jpg'
            ],
            // Desserts
            [
                'category' => 'Desserts',
                'name' => 'Tiramisu',
                'description' => 'Classic Italian dessert with coffee-soaked ladyfingers',
                'price' => 7.99,
                'prep_time' => 10,
                'image' => 'menu-items/tiramisu.jpg'
            ],
            [
                'category' => 'Desserts',
                'name' => 'Chocolate Lava Cake',
                'description' => 'Warm chocolate cake with a molten center',
                'price' => 8.99,
                'prep_time' => 15,
                'image' => 'menu-items/lava-cake.jpg'
            ],
            // Drinks
            [
                'category' => 'Drinks',
                'name' => 'Iced Tea',
                'description' => 'Refreshing freshly brewed iced tea',
                'price' => 3.99,
                'prep_time' => 5,
                'image' => 'menu-items/iced-tea.jpg'
            ],
            [
                'category' => 'Drinks',
                'name' => 'House Wine',
                'description' => 'Glass of our signature house wine',
                'price' => 7.99,
                'prep_time' => 5,
                'image' => 'menu-items/wine.jpg'
            ],
        ];

        foreach ($menuItems as $item) {
            $category = Category::where('name', $item['category'])->first();
            
            MenuItem::create([
                'category_id' => $category->id,
                'name' => $item['name'],
                'slug' => \Str::slug($item['name']),
                'description' => $item['description'],
                'price' => $item['price'],
                'prep_time' => $item['prep_time'],
                'image' => $item['image'],
                'is_active' => true,
            ]);
        }
    }
}