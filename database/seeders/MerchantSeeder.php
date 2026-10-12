<?php

namespace Database\Seeders;

use App\Models\Merchant;
use Illuminate\Database\Seeder;

class MerchantSeeder extends Seeder
{
    public function run(): void
    {
        $merchants = [
            [
                'name' => 'Ram Sharma',
                'email' => 'ram@merchant.test',
                'shop_name' => 'Ram Electronics',
                'contact' => '9800000001',
            ],
            [
                'name' => 'Sita Karki',
                'email' => 'sita@merchant.test',
                'shop_name' => 'Sita Fashion House',
                'contact' => '9800000002',
            ],
        ];

        foreach ($merchants as $data) {
            Merchant::updateOrCreate(
                ['email' => $data['email']],
                $data + [
                    'password' => 'password', // hashed automatically by the model cast
                    'status' => 'approve',
                ]
            );
        }
    }
}
