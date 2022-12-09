<?php

namespace Database\Seeders;

use App\Models\Denomination;
use Illuminate\Database\Seeder;

class DenominationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Denomination::create([
            'type' => 'BILLETE',
            'value' => 1,
        ]);

        Denomination::create([
            'type' => 'BILLETE',
            'value' => 5,
        ]);

        Denomination::create([
            'type' => 'BILLETE',
            'value' => 10,
        ]);

        Denomination::create([
            'type' => 'BILLETE',
            'value' => 20,
        ]);

        Denomination::create([
            'type' => 'BILLETE',
            'value' => 50,
        ]);

        Denomination::create([
            'type' => 'BILLETE',
            'value' => 100,
        ]);

        Denomination::create([
            'type' => 'MONEDA',
            'value' => 0.01,
        ]);

        Denomination::create([
            'type' => 'MONEDA',
            'value' => 0.05,
        ]);

        Denomination::create([
            'type' => 'MONEDA',
            'value' => 0.10,
        ]);

        Denomination::create([
            'type' => 'MONEDA',
            'value' => 0.25,
        ]);

        Denomination::create([
            'type' => 'OTRO',
            'value' => 0,
        ]);
    }
}
