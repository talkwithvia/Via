<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

/**
 * Seeds the products table with sample BFSUMA store products.
 * Run: php artisan db:seed --class=ProductSeeder
 */
class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Only seed if table is empty to avoid duplicates
        if (Product::count() > 0) {
            return;
        }

        $products = [
            // Stationery
            ['name' => 'Via Notebook',        'price' => '850',    'category' => 'Stationery', 'stock' => 40,  'description' => 'A premium lined notebook with the Via logo — perfect for planning and journaling.'],
            ['name' => 'Via Pen Set',          'price' => '450',    'category' => 'Stationery', 'stock' => 60,  'description' => 'A set of 3 smooth-writing ballpoint pens in slate, cream, and terra.'],
            // Apparel
            ['name' => 'Via Tote Bag',         'price' => '1,200',  'category' => 'Apparel',    'stock' => 25,  'description' => 'A clean, minimal canvas tote bag in cream with a small Via wordmark.'],
            ['name' => 'Via Cap',              'price' => '1,500',  'category' => 'Apparel',    'stock' => 20,  'description' => 'A structured cap in slate — understated and versatile.'],
            ['name' => 'Via T-Shirt',          'price' => '1,800',  'category' => 'Apparel',    'stock' => 30,  'description' => 'Unisex premium cotton tee with a minimal Via chest print.'],
            // Digital
            ['name' => 'Goal-Setting Template','price' => '250',    'category' => 'Digital',    'stock' => 999, 'description' => 'A Notion template for quarterly goal setting and weekly reviews.'],
            ['name' => 'Via Masterclass',      'price' => '3,500',  'category' => 'Digital',    'stock' => 999, 'description' => 'Full access to the Via recorded masterclass series — 8 modules.'],
            // Services
            ['name' => 'Mentor Session (1hr)', 'price' => '3,500',  'category' => 'Service',    'stock' => 10,  'description' => 'A one-hour 1-on-1 session with a Via community mentor of your choice.'],
            ['name' => 'CV Review',            'price' => '1,000',  'category' => 'Service',    'stock' => 20,  'description' => 'Professional review and feedback on your CV/resume within 48 hours.'],
        ];

        foreach ($products as $p) {
            Product::create(array_merge($p, ['status' => 'Active']));
        }
    }
}
