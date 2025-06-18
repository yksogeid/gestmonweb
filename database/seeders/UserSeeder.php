<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    Permission::create(['name' => 'ver usuarios']);
    Permission::create(['name' => 'crear usuarios']);
    Permission::create(['name' => 'editar usuarios']);
    Permission::create(['name' => 'eliminar usuarios']);

    Permission::create(['name' => 'ver libros']);
    Permission::create(['name' => 'crear libros']);
    Permission::create(['name' => 'editar libros']);
    Permission::create(['name' => 'eliminar libros']);

    // Crear roles primero
    $roleAdmin = Role::create(['name' => 'super-admin']);
    $roleStudent = Role::create(['name' => 'student']);

    // Crear usuarios
    $adminUser = User::query()->create([
        'name' => 'Admin',
        'email' => 'admin@admin.com',
        'password' => bcrypt('admin1234'),
        'email_verified_at' => now(),
    ]);
    $studentUser = User::query()->create([
        'name' => 'Student',
        'email' => 'student@student.com',
        'password' => bcrypt('student1234'),
        'email_verified_at' => now(),
    ]);

    // Asignar roles
    $adminUser->assignRole($roleAdmin);
    $studentUser->assignRole($roleStudent);

    // Asignar permisos
    $permissionsAdmin = Permission::query()->pluck('name');
    $roleAdmin->syncPermissions($permissionsAdmin);
    $roleStudent->syncPermissions(['ver librosss']);
}

}
