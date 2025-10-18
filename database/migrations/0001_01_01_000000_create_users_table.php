<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nama_depan', 100);
            $table->string('nama_belakang', 100);
            $table->string('sekolah_universitas', 150)->nullable();
            $table->string('nama_pembimbing', 150)->nullable();
            $table->string('periode_magang', 100)->nullable();
            $table->string('cv')->nullable(); // simpan path file CV
            $table->string('email')->unique();
            $table->string('no_telp', 20)->nullable();
            $table->string('username', 100)->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
