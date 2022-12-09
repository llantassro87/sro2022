<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Company::create([
            'name' => 'Venta de Llantas Nuevas y Usadas, Frenos y Lubricantes "SRO".',
            'address' => 'Calle El Litoral, Bo. Nueva Alianza, San Rafael Obrajuelo, La Paz.',
            'phone' => '2222-2222',
            'taxpayer_id' => '0817-220265-101-6'
        ]);
    }
}
