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
        Role::whereName('admin')->updateOrCreate(['name' => 'admin']);
        Role::whereName('user')->updateOrCreate(['name' => 'user']);
        $main_permissions = [
            'الضباط',
            'الوحدات',
            'مخالفات الوحدات',
            'عناوين المخالفات',
        ];
        $all_permissions = [];
        $crud = ['اضافة', 'عرض', 'تعديل', 'حذف'];
        foreach ($main_permissions as $permission) {
            foreach ($crud as $task) {
                $all_permissions[] = ['name' => "$task $permission"];
            }
        }
        $all_permissions[] = ['name' => "عرض اجمالي المخالفات"];
        foreach ($all_permissions as $permission) {
            $permission = Permission::whereName($permission)->updateOrCreate($permission);
        }
    }
}
