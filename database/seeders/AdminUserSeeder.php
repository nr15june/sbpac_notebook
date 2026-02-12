<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        Admin::updateOrCreate(
            ['username' => 'adminit'],
            [
                'name' => 'ผู้ดูแลระบบ',
                'password' => Hash::make('123456'),
            ]
        );
    }
}
