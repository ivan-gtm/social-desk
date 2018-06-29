<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScrapperAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scrapper_accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('type', 100)->index();
            $table->bigInteger('origin_id')->unsigned()->index();
            $table->string('username', 150)->index();
            $table->boolean('status')->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scrapper_accounts');
    }
}
