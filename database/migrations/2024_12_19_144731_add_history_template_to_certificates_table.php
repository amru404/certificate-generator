<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHistoryTemplateToCertificatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::table('certificates', function (Blueprint $table) {
        $table->string('history_template')->nullable();
    });
}

public function down()
{
    Schema::table('certificates', function (Blueprint $table) {
        $table->dropColumn('history_template');
    });
}

}
