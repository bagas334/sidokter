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
            $table->unsignedBigInteger('pegawai_id')->primary(); // Primary key is pegawai_id
            $table->string('email')->unique(); // Email, must be unique
            $table->string('password'); // Password field
            $table->rememberToken(); // Remember token for authentication
            $table->timestamp('email_verified_at')->nullable(); // Email verification timestamp
            $table->timestamps(); // created_at and updated_at timestamps
            $table->foreign('pegawai_id')->references('id')->on('pegawai')->onDelete('cascade');
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
