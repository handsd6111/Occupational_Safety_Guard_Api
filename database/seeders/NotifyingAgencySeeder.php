<?php

namespace Database\Seeders;

use App\Models\NotifyingAgency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NotifyingAgencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        NotifyingAgency::firstOrCreate([
            'agency_name' => '無',
            'address' => '無',
            'notified_hotline_at_work' => '無',
            'notified_hotline_off_work' => '無'
        ]);
    }
}
