<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('accessories')->insert([
            [
                'name' => 'Mouse',
                'type' => 'notebook',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Charging Cable',
                'type' => 'notebook',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'USB Printer Cable',
                'type' => 'printer',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Spare Ink Cartridge',
                'type' => 'printer',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('accessories')
            ->whereIn('name', [
                'Mouse',
                'Charging Cable',
                'USB Printer Cable',
                'Spare Ink Cartridge',
            ])
            ->delete();
    }
};
