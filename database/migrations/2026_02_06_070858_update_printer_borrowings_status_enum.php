<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
            ALTER TABLE printer_borrowings
            MODIFY status ENUM(
                'pending',
                'borrowed',
                'returned',
                'rejected'
            ) NOT NULL
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("
            ALTER TABLE printer_borrowings
            MODIFY status ENUM(
                'pending',
                'borrowed',
                'returned'
            ) NOT NULL
        ");
    }
};
