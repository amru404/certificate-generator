<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('nama_event');
            $table->string('email');
            $table->string('no_telp', 32);
            $table->text('deskripsi');
            $table->date('tanggal');
            $table->json('logo')->nullable();
            $table->json('cap')->nullable(); 
            $table->json('ttd')->nullable(); 
            $table->string('nomor_certificate')->nullable();
            $table->boolean('tampilkan_nama_event')->default(true);
            $table->boolean('tampilkan_email')->default(true);
            $table->boolean('tampilkan_no_telp')->default(true);
            $table->boolean('tampilkan_deskripsi')->default(true);
            $table->boolean('tampilkan_tanggal')->default(true);
            $table->timestamps();
    
            $table->foreign('user_id')->on('users')->references('id')->onDelete('CASCADE')->onUpdate('CASCADE');
        });
    }
    
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
