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
        Schema::create('pkm_dosen', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Foreign Key mengacu ke tabel users
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users') // Mengacu ke tabel users
                  ->onDelete('cascade'); // Jika user dihapus, data ini ikut terhapus
            $table->text('judul_pkm');
            $table->text('dosen');
            $table->text('mahasiswa');
            $table->enum('tingkat', ['internasional', 'nasional', 'lokal']);
            $table->string('sumber_dana');
            $table->enum('kesesuaian_roadmap', ['Sesuai', 'Kurang Sesuai', 'Tidak Sesuai']);
            $table->string('bentuk_integrasi');
            $table->string('mata_kuliah');
            $table->unsignedBigInteger('tahun_akademik_id')->nullable(); // Foreign Key mengacu ke tabel tahun akademik id
            $table->foreign('tahun_akademik_id')
                  ->references('id')
                  ->on('tahun_akademik') // Mengacu ke tabel tahun akademik
                  ->onDelete('cascade'); // Jika user dihapus, data ini ikut terhapus
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pkm_dosen');
    }
};
