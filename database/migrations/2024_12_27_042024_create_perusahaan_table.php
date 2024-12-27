<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerusahaanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perusahaan', function (Blueprint $table) {
            $table->id(); // Primary key, auto-increment
            $table->string('idsbr')->nullable();
            $table->string('kode_wilayah')->nullable();
            $table->string('nama_usaha');
            $table->string('sls')->nullable();
            $table->text('alamat_detail')->nullable();
            $table->string('kode_kbli')->nullable();
            $table->string('nama_cp')->nullable();
            $table->string('nomor_cp')->nullable();
            $table->string('email')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('perusahaan');
    }
}
