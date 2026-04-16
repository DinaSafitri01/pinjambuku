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
        if (!Schema::hasTable('buku')) {
            Schema::create('buku', function (Blueprint $table) {
                $table->id();
                $table->string('judul');
                $table->string('penulis');
                $table->string('penerbit');
                $table->year('tahun_terbit');
                $table->integer('stok')->default(0);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('anggota')) {
            Schema::create('anggota', function (Blueprint $table) {
                $table->id();
                $table->string('nis')->unique();
                $table->string('nama');
                $table->text('alamat')->nullable();
                $table->string('no_telp')->nullable();
                $table->string('email')->unique();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buku');
    }
};
