<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'category_slug' => 'electronics',
                'name' => 'Mechanical Keyboard',
                'description' => 'A clean mechanical keyboard for developers.',
                'price' => 7999,
                'stock' => 10,
            ],
            [
                'category_slug' => 'electronics',
                'name' => 'Wireless Mouse',
                'description' => 'A comfortable wireless mouse for daily work.',
                'price' => 2999,
                'stock' => 15,
            ],
            [
                'category_slug' => 'clothes',
                'name' => 'Laravel Hoodie',
                'description' => 'A comfortable hoodie for Laravel developers.',
                'price' => 4999,
                'stock' => 8,
            ],
            [
                'category_slug' => 'books',
                'name' => 'Clean Code Book',
                'description' => 'A practical book about writing cleaner code.',
                'price' => 3999,
                'stock' => 12,
            ],
            [
                'category_slug' => 'home-kitchen',
                'name' => 'Coffee Maker',
                'description' => 'A compact coffee maker for your kitchen.',
                'price' => 6499,
                'stock' => 6,
            ],
            [
                'category_slug' => 'toys-games',
                'name' => 'Chess Board',
                'description' => 'A classic chess board for strategy lovers.',
                'price' => 2499,
                'stock' => 20,
            ],
            [
                'category_slug' => 'sports-outdoors',
                'name' => 'Yoga Mat',
                'description' => 'A comfortable yoga mat for home workouts.',
                'price' => 1999,
                'stock' => 25,
            ],
            [
                'category_slug' => 'music-movies',
                'name' => 'Vinyl Record',
                'description' => 'A classic vinyl record for music collectors.',
                'price' => 3499,
                'stock' => 9,
            ],
        ];
        foreach($products as $productData) {
            $category = Category::where('slug', $productData['category_slug'])->firstOrFail();

            Product::updateOrCreate(
                ['slug' => Str::slug($productData['name'])],
                [
                    'category_id' => $category->id,
                    'name' => $productData['name'],
                    'description' => $productData['description'],
                    'price' => $productData['price'],
                    'stock' => $productData['stock'],
                    'is_active' => true,
                ]
            );
        }
    }
}
