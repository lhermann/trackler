<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameLabelIdToEventIdInHitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hits', function (Blueprint $table) {
            $table->renameColumn('label_id', 'event_id');
            $table->foreign('event_id')
                ->references('id')->on('events')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hits', function (Blueprint $table) {
            $table->renameColumn('event_id', 'label_id');
            $table->foreign('label_id')
                ->references('id')->on('labels')->onDelete('cascade');
        });
    }
}
