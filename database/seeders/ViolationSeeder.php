<?php

namespace Database\Seeders;

use App\Models\Violation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ViolationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $violations = [
            [
                'title' => 'استبدال لوحات'
            ],
            [
                'title' => 'حجز وتحصيل'
            ],
            [
                'title' => 'الغاء'
            ],
            [
                'title' => 'ملصق جديد'
            ],
            [
                'title' => 'ملصق بدل تالف'
            ],
            [
                'title' => 'ورقي'
            ],
            [
                'title' => 'حجز على الشبكة'
            ],
            [
                'title' => 'سيارات متروكة'
            ],
            [
                'title' => 'عدم ترخيص مركبات النقل'
            ],
            [
                'title' => 'حجز المركبات المنتهية التراخيص'
            ],
            [
                'title' => 'تم التجديد'
            ],
            [
                'title' => 'الاستغناء عن الترخيص'
            ],
            [
                'title' => 'امتنع عن التجديد وامتنع عن تسليم اللوحات'
            ],
        ];
        foreach ($violations as $violation) {
            Violation::create($violation);
        }
    }
}
