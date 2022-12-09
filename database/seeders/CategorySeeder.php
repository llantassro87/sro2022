<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;


class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'name' => 'Frenos',
            'description' => 'Frenos',
            'image' => NULL
        ]);

        Category::create([
            'name' => 'Lubricantes',
            'description' => 'Lubricantes',
            'image' => NULL
        ]);

        Category::create([
            'name' => 'Llantas',
            'description' => 'Llantas',
            'image' => NULL
        ]);

        Category::create([
            'name' => 'Carwash',
            'description' => 'Carwash',
            'image' => NULL
        ]);
    }
}
