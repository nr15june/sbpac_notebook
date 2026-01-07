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
            ['email' => 'admin@sbpac.go.th'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('123456'),
            ]
        );
    }
}
