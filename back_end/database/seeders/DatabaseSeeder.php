<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // 1. Create User (Cashier)
        $user = User::where('email', 'admin@example.com')->first();
        if (!$user) {
            $user = User::create([
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]);
        }

        // 2. Create Categories
        $category1 = Category::create([
            'name' => 'Tiket Wisata Alam',
            'description' => 'Kategori untuk wisata alam',
            'image' => 'categories/alam.jpg',
        ]);

        $category2 = Category::create([
            'name' => 'Tiket Wahana',
            'description' => 'Kategori untuk wahana permainan',
            'image' => 'categories/wahana.jpg',
        ]);

        // 3. Create Products
        Product::create([
            'category_id' => $category1->id,
            'name' => 'Tiket Masuk Air Terjun',
            'description' => 'Tiket masuk ke area air terjun',
            'image' => 'products/air_terjun.jpg',
            'stock' => 100,
            'price' => 25000,
            'status' => 'published',
            'criteria' => 'Perorang',
            'favorite' => true,
        ]);

        Product::create([
            'category_id' => $category1->id,
            'name' => 'Tiket Camping Ground',
            'description' => 'Tiket sewa lahan camping',
            'image' => 'products/camping.jpg',
            'stock' => 50,
            'price' => 50000,
            'status' => 'published',
            'criteria' => 'Perorang',
            'favorite' => false,
        ]);

        Product::create([
            'category_id' => $category2->id,
            'name' => 'Tiket Flying Fox',
            'description' => 'Tiket wahana flying fox',
            'image' => 'products/flying_fox.jpg',
            'stock' => 200,
            'price' => 30000,
            'status' => 'published',
            'criteria' => 'Perorang',
            'favorite' => true,
        ]);

        Product::create([
            'category_id' => $category2->id,
            'name' => 'Paket Outbound',
            'description' => 'Paket lengkap outbound untuk grup',
            'image' => 'products/outbound.jpg',
            'stock' => 10,
            'price' => 150000,
            'status' => 'published',
            'criteria' => 'Perpaket',
            'favorite' => false,
        ]);
    }
}
