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
        Schema::create('aktivitas_staff', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ajuan_id');
            $table->tinyInteger('status_lama');
            $table->tinyInteger('status_baru');
            $table->timestamps();
    
            $table->foreign('ajuan_id')->references('id')->on('ajuan')->onDelete('cascade');
        });
    }
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aktivitas_staff');
    }
};
