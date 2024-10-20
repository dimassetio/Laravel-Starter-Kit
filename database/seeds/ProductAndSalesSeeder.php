<?php

use Illuminate\Database\Seeder;
use App\Product;
use App\Sale;
use Carbon\Carbon;

class ProductAndSalesSeeder extends Seeder
{
    public function run()
    {
        // Define product data
        $products = [
            [
                'name' => 'Green Tea',
                'description' => 'A refreshing green tea with a delicate flavor.',
                'price' => 15000,
            ],
            [
                'name' => 'Black Tea',
                'description' => 'A robust black tea with a bold flavor.',
                'price' => 10000,
            ],
            [
                'name' => 'Oolong Tea',
                'description' => 'A traditional oolong tea with a smooth taste.',
                'price' => 12500,
            ],
            [
                'name' => 'Chamomile Tea',
                'description' => 'A calming herbal tea with floral notes.',
                'price' => 8500,
            ],
            [
                'name' => 'Earl Grey Tea',
                'description' => 'A classic black tea with a hint of bergamot.',
                'price' => 11000,
            ],
        ];

        // Insert products and create sales data for each product
        foreach ($products as $productData) {
            $product = Product::create($productData);

            // Create sales for each month from January to October 2024
            for ($month = 1; $month <= 10; $month++) {
                $saleDate = Carbon::create(2024, $month, rand(1, 28)); // Random day in each month
                $quantity = rand(1, 20); // Random quantity between 1 and 20
                $price = $product->price;
                $total = $quantity * $price;

                Sale::create([
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $price,
                    'sale_date' => $saleDate,
                    'total' => $total,
                ]);
            }
        }
    }
}
