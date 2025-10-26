<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('rws', function (Blueprint $table) {
            $table->foreign('ketua_rw_warga_id')->references('id')->on('wargas')->onDelete('set null');
        });

        Schema::table('rts', function (Blueprint $table) {
            $table->foreign('ketua_rt_warga_id')->references('id')->on('wargas')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('rws', function (Blueprint $table) {
            $table->dropForeign(['ketua_rw_warga_id']);
        });

        Schema::table('rts', function (Blueprint $table) {
            $table->dropForeign(['ketua_rt_warga_id']);
        });
    }
};
