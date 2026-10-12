<?php

namespace Database\Seeders;

use App\Models\Merchant;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $catalog = [
            'ram@merchant.test' => [
                [
                    'name' => 'Wireless Earbuds',
                    'description' => '<p>Bluetooth 5.3 earbuds with noise isolation and a charging case.</p>',
                    'variants' => [
                        ['name' => 'Black', 'price' => 2499, 'discount' => 200],
                        ['name' => 'White', 'price' => 2499, 'discount' => 0],
                    ],
                ],
                [
                    'name' => 'Smart Watch',
                    'description' => '<p>Fitness tracking smart watch with a 1.8 inch display.</p>',
                    'variants' => [
                        ['name' => 'Silver 42mm', 'price' => 5999, 'discount' => 500],
                        ['name' => 'Black 46mm', 'price' => 6499, 'discount' => 500],
                    ],
                ],
                [
                    'name' => 'Power Bank',
                    'description' => '<p>Fast-charging power bank with dual USB output.</p>',
                    'variants' => [
                        ['name' => '10000mAh', 'price' => 1800, 'discount' => 100],
                        ['name' => '20000mAh', 'price' => 3200, 'discount' => 300],
                    ],
                ],
                [
                    'name' => 'Bluetooth Speaker',
                    'description' => '<p>Portable waterproof speaker with 12 hours of playtime.</p>',
                    'variants' => [
                        ['name' => 'Blue', 'price' => 3499, 'discount' => 0],
                        ['name' => 'Red', 'price' => 3499, 'discount' => 250],
                        ['name' => 'Black', 'price' => 3499, 'discount' => 250],
                    ],
                ],
            ],

            'sita@merchant.test' => [
                [
                    'name' => 'Cotton T-Shirt',
                    'description' => '<p>Soft 100% cotton round neck t-shirt.</p>',
                    'variants' => [
                        ['name' => 'Medium', 'price' => 799, 'discount' => 50],
                        ['name' => 'Large', 'price' => 849, 'discount' => 50],
                    ],
                ],
                [
                    'name' => 'Denim Jeans',
                    'description' => '<p>Slim fit stretch denim jeans.</p>',
                    'variants' => [
                        ['name' => '30 Waist', 'price' => 2200, 'discount' => 200],
                        ['name' => '32 Waist', 'price' => 2200, 'discount' => 200],
                    ],
                ],
                [
                    'name' => 'Woolen Hoodie',
                    'description' => '<p>Warm fleece-lined hoodie, ideal for winter.</p>',
                    'variants' => [
                        ['name' => 'Grey / M', 'price' => 2999, 'discount' => 300],
                        ['name' => 'Grey / L', 'price' => 2999, 'discount' => 300],
                        ['name' => 'Navy / L', 'price' => 3099, 'discount' => 0],
                    ],
                ],
                [
                    'name' => 'Canvas Backpack',
                    'description' => '<p>Durable canvas backpack with a laptop compartment.</p>',
                    'variants' => [
                        ['name' => '20L', 'price' => 1999, 'discount' => 100],
                        ['name' => '30L', 'price' => 2599, 'discount' => 150],
                    ],
                ],
            ],
        ];

        foreach ($catalog as $email => $products) {
            $merchant = Merchant::where('email', $email)->firstOrFail();

            foreach ($products as $item) {
                $product = Product::updateOrCreate(
                    ['slug' => str($merchant->shop_name . ' ' . $item['name'])->slug()],
                    [
                        'name' => $item['name'],
                        'img' => 'products/placeholder.png',
                        'description' => $item['description'],
                        'merchant_id' => $merchant->id,
                    ]
                );

                // Reset variants so re-running the seeder doesn't duplicate them
                $product->product_variants()->delete();

                $product->product_variants()->createMany(
                    collect($item['variants'])->map(fn($v) => $v + [
                        'img' => 'products/variants/placeholder.png',
                    ])->all()
                );
            }
        }
    }
}
