<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\District;
use App\Models\Province;
use Illuminate\Database\Seeder;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $province = Province::where('name', 'Balıkesir')->firstOrFail();

        $districts = [
            'Altıeylül',
            'Ayvalık',
            'Balya',
            'Bandırma',
            'Bigadiç',
            'Burhaniye',
            'Dursunbey',
            'Edremit',
            'Erdek',
            'Gömeç',
            'Gönen',
            'Havran',
            'İvrindi',
            'Karesi',
            'Kepsut',
            'Manyas',
            'Marmara',
            'Savaştepe',
            'Sındırgı',
            'Susurluk',
        ];

        foreach ($districts as $district) {
            District::firstOrCreate([
                'province_id' => $province->id,
                'name' => $district,
            ]);
        }
    }
}
