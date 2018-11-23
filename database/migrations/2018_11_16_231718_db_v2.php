<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DbV2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('presentations', function($table)
        {
            $table->string('grade')->nullable()->change();
        });

        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->text('post');
            $table->integer('subject_id');
            $table->timestamps();
        });

        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('comment');
            $table->string('date');
            $table->string('user_id');
            $table->string('post_id');
            $table->timestamps();
        });

        Schema::create('likes', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('date');
            $table->integer('user_id');
            $table->integer('post_id');
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
        Schema::table('presentations', function($table)
        {
            $table->string('grade')->nullable(false)->change();
        });

        Schema::dropIfExists('posts');
        Schema::dropIfExists('comments');
        Schema::dropIfExists('likes');
    }
}
