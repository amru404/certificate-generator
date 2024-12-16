<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('participant_id');
            $table->string('certificate_id', 50);
            $table->string('status')->default('pending'); 
            $table->text('error_message')->nullable();
            $table->timestamps();

            // Menambahkan foreign key constraint jika diperlukan
            $table->foreign('participant_id')->references('id')->on('participants')->onDelete('cascade');
            $table->foreign('certificate_id')->references('id')->on('certificates')->onDelete('cascade');
        });
    }

    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('email_logs');
    }
}
