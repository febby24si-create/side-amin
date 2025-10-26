<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersTableForAuth extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Tambah kolom baru
            $table->string('name')->after('id');
            $table->string('email')->after('name');

            // Hapus kolom lama (jika ada)
            if (Schema::hasColumn('users', 'username')) {
                $table->dropColumn('username');
            }
            if (Schema::hasColumn('users', 'nama_lengkap')) {
                $table->dropColumn('nama_lengkap');
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Kembalikan kolom lama
            $table->string('username')->unique();
            $table->string('nama_lengkap');

            // Hapus kolom baru
            $table->dropColumn(['name', 'email']);
        });
    }
}
