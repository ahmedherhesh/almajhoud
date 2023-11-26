<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::create(['name' => 'admin']);
        Role::create(['name' => 'user']);
        $permissions = [
            ['name' => 'تسجيل المخالفات'],
            ['name' => 'عرض المخالفات'],
            ['name' => 'تعديل المخالفات'],
            ['name' => 'حذف المخالفات'],
        ];
        foreach ($permissions as $permission) {
            $permission = Permission::create($permission);
            $permission->assignRole($admin);
        }
    }
}
