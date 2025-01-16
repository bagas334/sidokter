<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('pegawai_id')->nullable(); // Foreign key to pegawai table
            $table->string('email')->unique(); // Unique email
            $table->string('password'); // Password
            $table->string('jabatan');
            $table->string('fungsi_ketua_tim')->nullable(); // Jabatan
            $table->timestamp('email_verified_at')->nullable(); // Email verification timestamp
            $table->rememberToken(); // Remember token for authentication
            $table->timestamps(); // Created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user');
    }
};
