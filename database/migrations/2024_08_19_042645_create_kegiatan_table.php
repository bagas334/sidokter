<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKegiatanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kegiatan', function (Blueprint $table) {
            $table->id(); // Primary key with auto-increment
            $table->string('nama'); // Nama kegiatan
            $table->string('asal_fungsi'); // Asal fungsi atau departemen
            $table->date('tanggal_mulai'); // Tanggal mulai kegiatan
            $table->date('tanggal_akhir'); // Tanggal akhir kegiatan
            $table->integer('target'); // Target yang ingin dicapai
            $table->integer('terlaksana')->nullable(); // Jumlah yang terlaksana
            $table->string('satuan'); // Satuan target (misal: unit, orang, dll.)
            $table->integer('harga_satuan'); // Harga per satuan
            $table->text('catatan')->nullable(); // Catatan tambahan, bisa null

            $table->timestamps(); // created_at dan updated_at otomatis
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kegiatan');
    }
}
