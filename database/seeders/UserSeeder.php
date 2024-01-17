<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions =  Permission::pluck('name');
        $user = User::create([
            'name' => 'hesham diab',
            'username' => 'hesham_diab',
            'email' => 'heshamdiab@gmail.com',
            'password' => 'secret',
            'status' => 'active'
        ]);
        $user->assignRole('admin');
        $user->syncPermissions($permissions);
        $user = User::create([
            'name' => 'Ahmed Harhash',
            'username' => 'ahmed_herhesh',
            'email' => 'a@a.c',
            'password' => 'secret',
            'status' => 'active'
        ]);
        $user->assignRole('admin');
        $user->syncPermissions($permissions);

        User::factory(10)->create();
    }
}
