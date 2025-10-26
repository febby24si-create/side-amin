<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('anggota_lembagas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lembaga_id')->constrained('lembaga_desas')->onDelete('cascade');
            $table->foreignId('warga_id')->constrained('wargas')->onDelete('cascade');
            $table->foreignId('jabatan_id')->constrained('jabatan_lembagas')->onDelete('cascade');
            $table->date('tgl_mulai');
            $table->date('tgl_selesai')->nullable();
            $table->timestamps();

            $table->unique(['lembaga_id', 'warga_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('anggota_lembagas');
    }
};
