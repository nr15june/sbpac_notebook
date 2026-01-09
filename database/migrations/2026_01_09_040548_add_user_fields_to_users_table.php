<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('id_card', 20)->unique()->after('id');
            $table->string('first_name')->after('id_card');
            $table->string('last_name')->after('first_name');
            $table->string('phone', 20)->after('last_name');
            $table->string('department')->after('phone'); // สำนัก/กอง/ศูนย์
            $table->string('workgroup')->after('department'); // กลุ่มงาน
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'id_card',
                'first_name',
                'last_name',
                'phone',
                'department',
                'workgroup',
            ]);
        });
    }
};
