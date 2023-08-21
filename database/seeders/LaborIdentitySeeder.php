<?php

namespace Database\Seeders;

use App\Models\LaborIdentity;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LaborIdentitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        DB::table('labor_qualifiy_files')->truncate();
        DB::table('labor_files')->truncate();
        DB::table('labor_qualifies')->truncate();
        DB::table('labor_extra_identity_subsidies')->truncate();
        DB::table('labor_subsidies')->truncate();
        DB::table('labor_extra_identities')->truncate();
        DB::table('labor_identities')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $datas = [
            [
                'id' => 1,
                'name' => '有職保者',
            ],
            [
                'id' => 2,
                'name' => '退保後罹患職業病者'
            ],
            [
                'id' => 3,
                'name' => '無職保者'
            ]
        ];

        foreach ($datas as $data) {
            LaborIdentity::firstOrCreate($data);
        }
    }
}
