<?php

namespace Database\Seeders;

use App\Models\AccidentRecord;
use App\Models\CauseOfAccidentImage;
use App\Models\ContractRelationshipImage;
use App\Models\ImproveStrategyImage;
use App\Models\RefreshToken;
use App\Models\User;
use App\Models\Victim;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        CauseOfAccidentImage::truncate();
        ImproveStrategyImage::truncate();
        ContractRelationshipImage::truncate();
        Victim::truncate();
        DB::table('user_role')->truncate();
        RefreshToken::truncate();
        AccidentRecord::truncate();
        User::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
