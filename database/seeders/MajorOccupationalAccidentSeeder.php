<?php

namespace Database\Seeders;

use App\Models\MajorOccupationalAccident;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MajorOccupationalAccidentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MajorOccupationalAccident::firstOrCreate([
            'business_unit' => '力樺企業社',
            'detail_of_industry' => '業',
            'occurrence_date' => '2022/03/14',
            'number_of_victims' => 1,
            'business_owner' => '',
            'project_name' => '',
            'accident_location' => "苗栗縣大湖鄉暗坑步道常去亭往東2公里處產業道路(24°24'31.0\"N 120°52'44.0\"E)",
            'accident_address' => "苗栗縣大湖鄉暗坑步道常去亭往東2公里處產業道路(24°24'31.0\"N 120°52'44.0\"E)",
            'notifying_agency' => '2',
            'industry' => 'A',
            'accident_type' => '0004'
        ]);
    }
}
