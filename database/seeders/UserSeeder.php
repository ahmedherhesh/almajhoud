<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'hesham diab',
            'username' => 'hesham_diab',
            'email' => 'heshamdiab@gmail.com',
            'password' => 'secret',
            'status' => 'active'
        ]);
        $user->assignRole('admin');
        User::factory(10)->create();
    }
}
