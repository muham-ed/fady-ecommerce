<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Customer + admin accounts (login with password: "password")
        User::updateOrCreate(
            ['email' => 'test@example.com'],
            ['name' => 'Test User', 'password' => 'password', 'role' => 'customer']
        );

        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Admin User', 'password' => 'password', 'role' => 'admin']
        );

        // Sample catalogue so the storefront is not empty
        $categories = [
            'Electronics' => ['Wireless Headphones', 'Smart Watch', 'Bluetooth Speaker'],
            'Fashion' => ['Cotton T-Shirt', 'Denim Jacket', 'Running Shoes'],
            'Home' => ['Ceramic Mug', 'Desk Lamp', 'Throw Blanket'],
        ];

        foreach ($categories as $categoryName => $products) {
            $category = Category::updateOrCreate(
                ['slug' => Str::slug($categoryName)],
                ['name' => $categoryName, 'is_active' => true]
            );

            foreach ($products as $i => $productName) {
                $product = Product::updateOrCreate(
                    ['slug' => Str::slug($productName)],
                    [
                        'category_id' => $category->id,
                        'name' => $productName,
                        'short_description' => "High quality {$productName} from Fady store.",
                        'description' => "This is a detailed description for {$productName}.",
                        'price' => ($i + 1) * 199.99,
                        'sku' => strtoupper(Str::random(8)),
                        'stock_quantity' => 50,
                        'is_active' => true,
                        'is_featured' => $i === 0,
                    ]
                );

                ProductImage::updateOrCreate(
                    ['product_id' => $product->id, 'is_primary' => true],
                    [
                        'image_url' => 'https://picsum.photos/seed/'.$product->id.'/600/600',
                        'alt_text' => $productName,
                        'sort_order' => 0,
                    ]
                );
            }
        }
    }
}
