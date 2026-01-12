<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('notebooks', function (Blueprint $table) {
            $table->string('asset_code')->unique()->after('id');
            $table->string('brand')->after('asset_code');
            $table->string('model')->after('brand');
            $table->enum('status', ['available', 'borrowed', 'repair'])
                ->default('available')
                ->after('model');
            $table->text('note')->nullable()->after('status');
        });
    }

    public function down()
    {
        Schema::table('notebooks', function (Blueprint $table) {
            $table->dropColumn([
                'asset_code',
                'brand',
                'model',
                'status',
                'note'
            ]);
        });
    }
};
