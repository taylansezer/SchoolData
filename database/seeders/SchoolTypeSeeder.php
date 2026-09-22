<?php

namespace Database\Seeders;

use App\Models\SchoolType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SchoolTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run(): void
    {
        $schoolTypes = [
            [
                'name' => 'Anaokulu',
                'slug' => 'anaokulu',
            ],
            [
                'name' => 'Diğer Kurumlara Bağlı Eğitim ve/veya Bakım Hizmeti Veren Kurumlar',
                'slug' => 'diger-kurumlara-bagli-egitim-ve-veya-bakim-hizmeti-veren-kurumlar',
            ],
            [
                'name' => 'Özel Eğitim Anaokulu',
                'slug' => 'ozel-egitim-anaokulu',
            ],
            [
                'name' => 'Özel Türk Anaokulu',
                'slug' => 'ozel-turk-anaokulu',
            ],
            [
                'name' => 'İlkokul',
                'slug' => 'ilkokul',
            ],
            [
                'name' => 'Özel Eğitim İlkokulu',
                'slug' => 'ozel-egitim-ilkokulu',
            ],
            [
                'name' => 'Özel Türk İlkokulu',
                'slug' => 'ozel-turk-ilkokulu',
            ],
            [
                'name' => 'İmam Hatip Ortaokulu',
                'slug' => 'imam-hatip-ortaokulu',
            ],
            [
                'name' => 'Ortaokul',
                'slug' => 'ortaokul',
            ],
            [
                'name' => 'Özel Eğitim Ortaokulu',
                'slug' => 'ozel-egitim-ortaokulu',
            ],
            [
                'name' => 'Özel Türk Ortaokulu',
                'slug' => 'ozel-turk-ortaokulu',
            ],
            [
                'name' => 'Spor Ortaokulu',
                'slug' => 'spor-ortaokulu',
            ],
            [
                'name' => 'Yatılı Bölge Ortaokulu',
                'slug' => 'yatili-bolge-ortaokulu',
            ],
            [
                'name' => 'Anadolu İmam Hatip Lisesi',
                'slug' => 'anadolu-imam-hatip-lisesi',
            ],
            [
                'name' => 'Anadolu Lisesi',
                'slug' => 'anadolu-lisesi',
            ],
            [
                'name' => 'Çok Programlı Anadolu Lisesi',
                'slug' => 'cok-programli-anadolu-lisesi',
            ],
            [
                'name' => 'Fen Lisesi',
                'slug' => 'fen-lisesi',
            ],
            [
                'name' => 'Güzel Sanatlar Lisesi',
                'slug' => 'guzel-sanatlar-lisesi',
            ],
            [
                'name' => 'Meslekî Eğitim Merkezi',
                'slug' => 'mesleki-egitim-merkezi',
            ],
            [
                'name' => 'Meslekî ve Teknik Anadolu Lisesi',
                'slug' => 'mesleki-ve-teknik-anadolu-lisesi',
            ],
            [
                'name' => 'Özel Anadolu Lisesi',
                'slug' => 'ozel-anadolu-lisesi',
            ],
            [
                'name' => 'Özel Eğitim Meslek Okulu',
                'slug' => 'ozel-egitim-meslek-okulu',
            ],
            [
                'name' => 'Özel Eğitim Uygulama Okulu',
                'slug' => 'ozel-egitim-uygulama-okulu',
            ],
            [
                'name' => 'Özel Fen Lisesi',
                'slug' => 'ozel-fen-lisesi',
            ],
            [
                'name' => 'Sosyal Bilimler Lisesi',
                'slug' => 'sosyal-bilimler-lisesi',
            ],
            [
                'name' => 'Spor Lisesi',
                'slug' => 'spor-lisesi',
            ],
        ];

        foreach ($schoolTypes as $schoolType) {
            SchoolType::firstOrCreate(
                ['slug' => $schoolType['slug']],
                ['name' => $schoolType['name']]
            );
        }
    }
}
