<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerusahaanSampelTable extends Migration
{
    public function up()
    {
        Schema::create('perusahaan_sampel', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('sampel_id') // Foreign key ke tabel sampel
                ->constrained('sampel')
                ->onDelete('cascade');
            $table->foreignId('perusahaan_id') // Foreign key ke tabel perusahaan
                ->constrained('perusahaan')
                ->onDelete('cascade');
            $table->timestamps(); // Kolom waktu (created_at, updated_at)
        });
    }

    public function down()
    {
        Schema::dropIfExists('perusahaan_sampel');
    }
}
