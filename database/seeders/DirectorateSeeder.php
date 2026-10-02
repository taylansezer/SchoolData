<?php

namespace Database\Seeders;

use App\Models\Directorate;
use Illuminate\Database\Seeder;

class DirectorateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $directorates = [
            'Temel Eğitim Genel Müdürlüğü',
            'Ortaöğretim Genel Müdürlüğü',
            'Meslekî ve Teknik Eğitim Genel Müdürlüğü',
            'Din Öğretimi Genel Müdürlüğü',
            'Özel Eğitim ve Rehberlik Hizmetleri Genel Müdürlüğü',
            'Özel Öğretim Kurumları Genel Müdürlüğü',
            'Hayat Boyu Öğrenme Genel Müdürlüğü',
        ];

        foreach ($directorates as $name) {
            Directorate::firstOrCreate([
                'name' => $name,
            ]);
        }
    }
}
