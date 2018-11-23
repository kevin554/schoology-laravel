<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DbV1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();
        });

        Schema::create('teachers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();
        });

        Schema::create('subjects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->integer('teacher_id');
            $table->timestamps();
        });

        Schema::create('contents', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->integer('subject_id');
            $table->integer('order');
            $table->text('content');
            $table->timestamps();
        });

        Schema::create('signed_students', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('student_id');
            $table->integer('subject_id');
            $table->timestamps();
        });

        Schema::create('homeworks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('description');
            $table->dateTime('death_line');
            $table->double('max_grade');
            $table->integer('subject_id');
            $table->timestamps();
        });

        Schema::create('presentations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('student_id');
            $table->integer('homework_id');
            $table->double('grade');
            $table->dateTime('presentation_date');
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
        Schema::dropIfExists('students');
        Schema::dropIfExists('teachers');
        Schema::dropIfExists('subjects');
        Schema::dropIfExists('contents');
        Schema::dropIfExists('signed_students');
        Schema::dropIfExists('homeworks');
        Schema::dropIfExists('presentations');
    }
}
