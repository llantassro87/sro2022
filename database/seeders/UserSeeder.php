<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Jorge R.',
            'phone' => '0000-0000',
            'email' => 'a@a.com',
            'profile' => 'Administrador',
            'status' => 'ACTIVE',
            'password' => bcrypt('123')
        ]);

        $user->syncRoles('Administrador');

        $user = User::create([
            'name' => 'Alfredo G.',
            'phone' => '1111-1111',
            'email' => 'e@e.com',
            'profile' => 'Encargado',
            'status' => 'ACTIVE',
            'password' => bcrypt('123')
        ]);

        $user->syncRoles('Encargado');
    }
}
