<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMitraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mitra', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('sobat_id');
            $table->string('nama', 255);
            $table->enum('jenis_kelamin', ['L', 'P'])->default('L'); // 'L' untuk laki-laki, 'P' untuk perempuan
            $table->string('email')->unique();
            $table->string('kecamatan', 100)->nullable();
            $table->string('kelurahan', 100)->nullable();
            $table->text('alamat_detail')->nullable();
            $table->string('posisi', 50)->nullable();
            $table->decimal('pendapatan', 15, 2)->default(0); // Pendapatan dalam bentuk decimal
            $table->timestamps(); // Created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mitra');
    }
}
