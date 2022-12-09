<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::create([
            'name' => 'SPRIN BUSH 90385-15016',
            'cost' => 0.50,
            'price' => 1,
            'barcode' => '9213121092',
            'stock' => 100,
            'alert' => 10,
            'category_id' => 1,
            'image' => NULL
        ]);

        Product::create([
            'name' => 'MOTUL SAVE-LITE (SAE 5W-20) 1.05 G',
            'cost' => 41.76,
            'price' => 60,
            'barcode' => '123891239',
            'stock' => 26,
            'alert' => 10,
            'category_id' => 2,
            'image' => NULL
        ]);

        Product::create([
            'name' => '155-R13 (DUNLOP)',
            'cost' => 56.65,
            'price' => 83,
            'barcode' => '1823921839812',
            'stock' => 3,
            'alert' => 10,
            'category_id' => 3,
            'image' => NULL
        ]);

        Product::create([
            'name' => 'Servicio de carwash',
            'cost' => 3,
            'price' => 6,
            'barcode' => '9213121092',
            'stock' => 1000,
            'alert' => 10,
            'category_id' => 4,
            'image' => NULL
        ]);
    }
}
