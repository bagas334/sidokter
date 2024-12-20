<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePegawaiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pegawai', function (Blueprint $table) {
            $table->id();  // Auto incrementing primary key
            $table->string('nip')->unique();
            $table->string('nip_bps')->nullable()->unique();
            $table->string('nama');
            $table->string('alias')->nullable();
            $table->string('jabatan');
            $table->string('fungsi_ketua_tim')->nullable();
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
        Schema::dropIfExists('pegawai');
    }
}
