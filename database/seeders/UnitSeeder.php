<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $units = [
            [
                'title' => 'المنصورة'
            ],
            [
                'title' => 'بلقاس'
            ],
            [
                'title' => 'ميت غمر'
            ],
            [
                'title' => 'شربين'
            ],
            [
                'title' => 'دكرنس'
            ],
            [
                'title' => 'جمصه'
            ],
            [
                'title' => 'اجا'
            ],
            [
                'title' => 'السنبلاوين'
            ],
            [
                'title' => 'المنزلة'
            ]
        ];
        foreach ($units as $unit) {
            Unit::create($unit);
        }
    }
}
