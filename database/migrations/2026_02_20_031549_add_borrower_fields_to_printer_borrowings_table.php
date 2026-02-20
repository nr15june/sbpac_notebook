<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('printer_borrowings', function (Blueprint $table) {
            $table->string('borrower_first_name')->nullable()->after('user_id');
            $table->string('borrower_last_name')->nullable()->after('borrower_first_name');
            $table->string('borrower_phone')->nullable()->after('borrower_last_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('printer_borrowings', function (Blueprint $table) {
            $table->dropColumn([
                'borrower_first_name',
                'borrower_last_name',
                'borrower_phone'
            ]);
        });
    }
};
