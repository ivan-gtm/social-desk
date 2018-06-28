<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIgFeedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ig_feeds', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->bigInteger('ig_id')->unsigned()->index();
            $table->string('created_time', 100)->index();
            $table->string('type', 100)->index();
            $table->string('link', 100);
            $table->string('caption', 2000);
            $table->integer('likes_count')->unsigned()->index();
            $table->integer('comments_count')->unsigned()->index();
            $table->string('is_ad', 100);
            $table->string('thumbnail', 600);
            $table->string('images', 4000);
        });

        DB::unprepared('ALTER TABLE ig_feeds CONVERT TO CHARACTER SET utf8mb4');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ig_feeds');
    }
}
