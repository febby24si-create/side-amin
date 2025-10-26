<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('lembaga_desas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lembaga', 100);
            $table->text('deskripsi');
            $table->string('kontak', 20)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lembaga_desas');
    }
};
