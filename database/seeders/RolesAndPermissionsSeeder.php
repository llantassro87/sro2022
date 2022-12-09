<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions

        //roles
        Permission::create(['name' => 'actualizar roles']);
        Permission::create(['name' => 'buscar roles']);
        Permission::create(['name' => 'crear roles']);
        Permission::create(['name' => 'ver roles']);
        Permission::create(['name' => 'ver asignar']);

        //menu
        Permission::create(['name' => 'administracion']);
        Permission::create(['name' => 'inventario']);
        Permission::create(['name' => 'pos']);

        //usuarios
        Permission::create(['name' => 'actualizar usuarios']);
        Permission::create(['name' => 'buscar usuarios']);
        Permission::create(['name' => 'crear usuarios']);
        Permission::create(['name' => 'ver usuarios']);

        //categorias
        Permission::create(['name' => 'actualizar categorias']);
        Permission::create(['name' => 'buscar categorias']);
        Permission::create(['name' => 'crear categorias']);
        Permission::create(['name' => 'eliminar categorias']);
        Permission::create(['name' => 'ver categorias']);

        //productos
        Permission::create(['name' => 'actualizar productos']);
        Permission::create(['name' => 'buscar productos']);
        Permission::create(['name' => 'ver productos']);

        //compras
        Permission::create(['name' => 'buscar compras']);
        Permission::create(['name' => 'crear compras']);
        Permission::create(['name' => 'ver compras']);
        
        //proveedores
        Permission::create(['name' => 'actualizar proveedores']);
        Permission::create(['name' => 'buscar proveedores']);
        Permission::create(['name' => 'crear proveedores']);
        Permission::create(['name' => 'ver proveedores']);

        //denominaciones
        Permission::create(['name' => 'actualizar denominaciones']);
        Permission::create(['name' => 'buscar denominaciones']);
        Permission::create(['name' => 'crear denominaciones']);
        Permission::create(['name' => 'eliminar denominaciones']);
        Permission::create(['name' => 'ver denominaciones']);

        //reportes
        Permission::create(['name' => 'ver reportes']);

        //caja
        Permission::create(['name' => 'ver caja']);

        //caja
        Permission::create(['name' => 'ver ventas']);

        // create roles and assign created permissions
        $role = Role::create(['name' => 'Administrador']);
        $role->givePermissionTo(Permission::all());

        $role = Role::create(['name' => 'Encargado'])
            ->givePermissionTo(['actualizar categorias', 'buscar categorias', 'crear categorias', 'eliminar categorias', 'ver categorias',
                                'actualizar productos', 'buscar productos', 'ver productos', 
                                'buscar compras', 'crear compras', 'ver compras',
                                'actualizar proveedores', 'buscar proveedores', 'crear proveedores', 'ver proveedores',
                                'actualizar denominaciones', 'buscar denominaciones', 'crear denominaciones', 'eliminar denominaciones', 'ver denominaciones',
                                'ver reportes', 'ver caja', 'ver ventas',
                                'inventario', 'pos']);

    }
}
