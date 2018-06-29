<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScrapperPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scrapper_posts', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->bigInteger('task_id')->unsigned()->index();
            $table->bigInteger('account_id')->unsigned()->index();
            $table->string('identifier', 200);
            $table->string('url', 200);
            $table->string('data', 200);
            $table->integer('post_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scrapper_posts');
    }
}
