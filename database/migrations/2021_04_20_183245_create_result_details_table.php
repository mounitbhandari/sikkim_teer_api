<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResultDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('result_details', function (Blueprint $table) {
            $table->id();

            $table->integer('result_row');
            $table->integer('result_col');
            $table->float('payout')->default(0)->nullable(false);

            $table->bigInteger('result_master_id')->unsigned()->nullable(false);
            $table ->foreign('result_master_id')->references('id')->on('result_masters');

            $table->bigInteger('play_series_id')->unsigned()->nullable(true);
            $table ->foreign('play_series_id')->references('id')->on('play_series');

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
        Schema::dropIfExists('result_details');
    }
}
