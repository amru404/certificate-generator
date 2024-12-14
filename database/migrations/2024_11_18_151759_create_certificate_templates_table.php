<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCertificateTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('certificate_templates', function (Blueprint $table) {
        $table->id();
        $table->string('nama_template');
        $table->string('preview'); 
        $table->string('nama')->default('0px 0px 0px 0px');
        $table->string('deskripsi')->default('0px 0px 0px 0px');
        $table->string('tanggal')->default('0px 0px 0px 0px');
        $table->string('ttd')->default('0px 0px 0px 0px');
        $table->string('uid')->default('0px 0px 0px 0px');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('certificate_templates');
    }
}
