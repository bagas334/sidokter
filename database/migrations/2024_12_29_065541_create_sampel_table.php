<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSampelTable extends Migration
{
    public function up()
    {
        Schema::create('sampel', function (Blueprint $table) {
            $table->id();
            $table->string('nama'); // Nama sampel
            $table->text('deskripsi')->nullable(); // Deskripsi sampel (opsional)
            $table->foreignId('dibuat_oleh')->constrained('pegawai')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sampel');
    }
}
