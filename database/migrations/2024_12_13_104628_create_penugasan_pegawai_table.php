<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenugasanPegawaiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penugasan_pegawai', function (Blueprint $table) {
            $table->id();  // Auto incrementing primary key
            $table->foreignId('petugas')->constrained('pegawai')->onDelete('cascade'); // Foreign key for petugas
            $table->foreignId('kegiatan_id')->constrained('kegiatan')->onDelete('cascade'); // Foreign key for kegiatan
            $table->date('tanggal_penugasan');
            $table->string('jabatan');
            $table->string('status');
            $table->integer('target');
            $table->integer('terlaksana')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps(); // created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penugasan_pegawai');
    }
}
