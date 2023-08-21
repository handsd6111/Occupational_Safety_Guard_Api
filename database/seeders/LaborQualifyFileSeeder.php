<?php

namespace Database\Seeders;

use App\Models\LaborQualifyFile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LaborQualifyFileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [];

        for ($i = 40; $i <= 41; $i++) {
            $datas[] = [
                'lq_id' => 21,
                'lf_id' => $i,
            ];
        }

        for ($i = 42; $i <= 48; $i++) {
            $datas[] = [
                'lq_id' => 22,
                'lf_id' => $i,
            ];
        }

        for ($i = 49; $i <= 52; $i++) {
            $datas[] = [
                'lq_id' => 23,
                'lf_id' => $i,
            ];
            $datas[] = [
                'lq_id' => 24,
                'lf_id' => $i,
            ];
        }

        for ($i = 53; $i <= 56; $i++) {
            $datas[] = [
                'lq_id' => 25,
                'lf_id' => $i,
            ];
            $datas[] = [
                'lq_id' => 26,
                'lf_id' => $i,
            ];
            $datas[] = [
                'lq_id' => 27,
                'lf_id' => $i,
            ];
        }

        for ($i = 57; $i <= 66; $i++) {
            if($i == 61) continue;
            $datas[] = [
                'lq_id' => 28,
                'lf_id' => $i,
            ];
        }

        for ($i = 57; $i <= 61; $i++) {
            $datas[] = [
                'lq_id' => 29,
                'lf_id' => $i,
            ];
        }

        for ($i = 57; $i <= 63; $i++) {
            if($i == 61) continue;
            $datas[] = [
                'lq_id' => 30,
                'lf_id' => $i,
            ];
        }

        $datas[] = [
            'lq_id' => 30,
            'lf_id' => 68,
        ];

        for ($i = 57; $i <= 60; $i++) {
            $datas[] = [
                'lq_id' => 31,
                'lf_id' => $i,
            ];
        }

        for ($i = 69; $i <= 72; $i++) {
            $datas[] = [
                'lq_id' => 32,
                'lf_id' => $i,
            ];
        }

        for ($i = 73; $i <= 76; $i++) {
            $datas[] = [
                'lq_id' => 33,
                'lf_id' => $i,
            ];
        }        

        $datas[] = [
            'lq_id' => 34,
            'lf_id' => 54,
        ];

        for ($i = 77; $i <= 79; $i++) {
            $datas[] = [
                'lq_id' => 34,
                'lf_id' => $i,
            ];
        }

        $datas[] = [
            'lq_id' => 35,
            'lf_id' => 80,
        ];

        for ($i = 79; $i <= 85; $i++) {
            if($i == 80) continue;
            $datas[] = [
                'lq_id' => 36,
                'lf_id' => $i,
            ];
        }

        $datas[] = [
            'lq_id' => 37,
            'lf_id' => 54,
        ];

        $datas[] = [
            'lq_id' => 38,
            'lf_id' => 54,
        ];

        for ($i = 86; $i <= 88; $i++) {
            $datas[] = [
                'lq_id' => 37,
                'lf_id' => $i,
            ];
            $datas[] = [
                'lq_id' => 38,
                'lf_id' => $i,
            ];
        }

        $datas[] = [
            'lq_id' => 39,
            'lf_id' => 83,
        ];

        for ($i = 89; $i <= 93; $i++) {
            $datas[] = [
                'lq_id' => 39,
                'lf_id' => $i,
            ];
        }

        foreach ($datas as $data) {
            LaborQualifyFile::firstOrCreate($data);
        }
    }
}
