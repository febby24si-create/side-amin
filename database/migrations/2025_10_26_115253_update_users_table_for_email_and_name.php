<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersTableForEmailAndName extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Tambahkan kolom email dan name jika belum ada
            if (!Schema::hasColumn('users', 'email')) {
                $table->string('email')->unique()->after('id');
            }
            if (!Schema::hasColumn('users', 'name')) {
                $table->string('name')->after('email');
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Hapus kolom email dan name
            $table->dropColumn(['email', 'name']);
        });
    }
}
