<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScrapperTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scrapper_tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->dateTime('scheduled_at');
            $table->dateTime('finished_at');
            $table->bigInteger('account_id')->unsigned()->index();
            $table->boolean('is_recurrent');
            $table->boolean('status');
            $table->integer('interval');
            $table->string('unit', 200)->index();
            $table->string('type',200)->index();
            $table->string('origin_id',200)->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scrapper_tasks');
    }
}
