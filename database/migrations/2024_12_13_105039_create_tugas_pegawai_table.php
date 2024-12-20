<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('tugas_pegawai', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penugasan_pegawai')->constrained('penugasan_pegawai')->onDelete('cascade');
            $table->integer('dikerjakan');
            $table->string('bukti')->nullable(); // String column
            $table->enum('status', ['diajukan', 'proses', 'selesai', 'ditolak']); // Enum column
            $table->text('catatan')->nullable();
            $table->timestamps(); // created_at 
        });
    }

    public function down()
    {
        Schema::dropIfExists('tugas_pegawai');
    }
};
