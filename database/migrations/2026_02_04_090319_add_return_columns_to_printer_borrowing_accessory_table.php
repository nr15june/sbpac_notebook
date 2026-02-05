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
        Schema::table('printer_borrowing_accessory', function (Blueprint $table) {
            $table->boolean('is_returned')->default(0)->after('accessory_id');
            $table->string('note')->nullable()->after('is_returned');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('printer_borrowing_accessory', function (Blueprint $table) {
            $table->dropColumn(['is_returned', 'note']);
        });
    }
};
