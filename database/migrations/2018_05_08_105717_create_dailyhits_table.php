<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDailyhitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hits', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('count')->unsigned();
            $table->string('timeframe', 20);
            $table->date('date');
            $table->unsignedInteger('label_id');
            $table->foreign('label_id')
                ->references('id')->on('labels')->onDelete('cascade');
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
        Schema::dropIfExists('hits');
    }
}
