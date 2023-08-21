<?php

namespace Database\Seeders;

use App\Models\LaborExtraIdentity;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LaborExtraIdentitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            [
                'id' => 4,
                'name' => '無',
                'li_id' => 1,
            ],
            [
                'id' => 5,
                'name' => '無',
                'li_id' => 2,
            ],
            [
                'id' => 6,
                'name' => '受雇勞工，但投保單位未加保',
                'li_id' => 3,
            ],
            [
                'id' => 7,
                'name' => '其他未加保勞工',
                'li_id' => 3
            ]
        ];
        
        foreach ($datas as $data) {
            LaborExtraIdentity::firstOrCreate($data);
        }
    }
}
