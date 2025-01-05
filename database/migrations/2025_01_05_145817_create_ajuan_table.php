<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAjuanTable extends Migration
{
    public function up()
    {
        Schema::create('ajuan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Menambahkan kolom user_id
            $table->string('nama');
            $table->string('asal');
            $table->string('whatsapp');
            $table->integer('jumlah_orang');
            $table->enum('jenis', [1, 2]);
            $table->date('tanggal');
            $table->time('jam');
            $table->enum('status', [1, 2, 3])->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ajuan');
    }
}

