<?php

namespace Database\Seeders;

use App\Models\LaborExtraIdentitySubsidy;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LaborExtraIdentitySubsidySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $datas = [];

        for ($i = 8; $i <= 13; $i++) {
            $datas[] = [
                'lei_id' => 4,
                'ls_id' => $i,
            ];
            $datas[] = [
                'lei_id' => 6,
                'ls_id' => $i,
            ];
        }

        for ($i = 14; $i <= 17; $i++) {
            $datas[] = [
                'lei_id' => 5,
                'ls_id' => $i,
            ];
        }

        for ($i = 18; $i <= 20; $i++) {
            $datas[] = [
                'lei_id' => 7,
                'ls_id' => $i,
            ];
        }

        foreach ($datas as $data) {
            LaborExtraIdentitySubsidy::firstOrCreate($data);
        }
    }
}
