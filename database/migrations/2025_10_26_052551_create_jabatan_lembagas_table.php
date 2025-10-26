<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('jabatan_lembagas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lembaga_id')->constrained('lembaga_desas')->onDelete('cascade');
            $table->string('nama_jabatan', 100);
            $table->enum('level', ['Ketua', 'Sekretaris', 'Bendahara', 'Anggota', 'Lainnya']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jabatan_lembagas');
    }
};
