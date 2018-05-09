<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveDateFromHits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hits', function (Blueprint $table) {
            $table->dropColumn('date');
            $table->dropColumn('identifier');
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
            $table->date('date')->nullable();
            $table->integer('identifier')
                ->after('label_id')
                ->unsigned()
                ->nullable();
        });
    }
}
