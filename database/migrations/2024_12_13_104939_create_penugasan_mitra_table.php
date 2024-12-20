<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenugasanMitraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penugasan_mitra', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('petugas')->constrained('mitra')->onDelete('cascade'); // Relasi ke tabel mitra
            $table->foreignId('kegiatan_id')->constrained('kegiatan')->onDelete('cascade'); // Relasi ke tabel kegiatan
            $table->date('tanggal_penugasan'); // Tanggal penugasan
            $table->foreignId('pemberi_tugas')->nullable()->constrained('pegawai')->onDelete('set null');
            $table->string('jabatan', 100)->nullable(); // Jabatan
            $table->integer('target');
            $table->integer('terlaksana')->nullable();
            $table->text('catatan')->nullable(); // Catatan (nullable)
            $table->timestamps(); // Timestamps untuk created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penugasan_mitra');
    }
}
