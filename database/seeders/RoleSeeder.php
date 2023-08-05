<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'id' => 'admin',
                'name' => '管理員',
            ],
            [
                'id' => 'user',
                'name' => '使用者'
            ]
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate($role);
        }
    }
}
