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
        Schema::create('ajuan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->integer('jumlah_orang');
            $table->enum('jenis', [1, 2])->nullable();
            $table->date('tanggal');
            $table->time('jam');
            $table->enum('status', [1, 2, 3, 4])->default(1);
            $table->string('surat')->nullable(); 
            $table->string('surat_balasan')->nullable();
            $table->text('deskripsi')->nullable(); 
            $table->timestamps();
    
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ajuan');
    }
};
