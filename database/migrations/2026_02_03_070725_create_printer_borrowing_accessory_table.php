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
        Schema::create('printer_borrowing_accessory', function (Blueprint $table) {
            $table->id();

            $table->foreignId('printer_borrowing_id')
                ->constrained('printer_borrowings')
                ->onDelete('cascade');

            $table->foreignId('accessory_id')
                ->constrained('accessories')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('printer_borrowing_accessory');
    }
};
