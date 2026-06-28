<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'pgsql_berita';

    public function up(): void
    {
        Schema::connection('pgsql_berita')->create('beritas', function (Blueprint $table) {
            $table->id('id_berita');
            $table->string('judul', 200);
            $table->text('isi');
            $table->date('tanggal');
            $table->unsignedBigInteger('id_kategori');
            $table->unsignedBigInteger('id_admin');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::connection('pgsql_berita')->dropIfExists('beritas');
    }
};