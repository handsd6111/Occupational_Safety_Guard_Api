<?php

namespace Database\Seeders;

use App\Models\LaborSubsidy;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LaborSubsidySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            [
                'id' => 8,
                'name' => '醫療給付',

            ],
            [
                'id' => 9,
                'name' => '傷病給付',

            ],
            [
                'id' => 10,
                'name' => '照護補助',

            ],
            [
                'id' => 11,
                'name' => '失能給付',
            ],
            [
                'id' => 12,
                'name' => '死亡給付',

            ],
            [
                'id' => 13,
                'name' => '失蹤給付',

            ],
            [
                'id' => 14,
                'name' => '醫療補助',

            ],
            [
                'id' => 15,
                'name' => '失能津貼',

            ],
            [
                'id' => 16,
                'name' => '照護補助',

            ],
            [
                'id' => 17,
                'name' => '死亡津貼',
            ],
            [
                'id' => 18,
                'name' => '失能補助',

            ],
            [
                'id' => 19,
                'name' => '照護補助',

            ],
            [
                'id' => 20,
                'name' => '死亡補助',

            ],
        ];

        foreach ($datas as $data) {
            LaborSubsidy::firstOrCreate($data);
        }
    }
}
