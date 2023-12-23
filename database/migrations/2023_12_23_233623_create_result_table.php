<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('result', function (Blueprint $table) {
            $table->id('result_id');
        });
        Schema::table('result', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');

            $table->foreign('user_id')->references('id')->on('users');
        });
        Schema::table('result', function (Blueprint $table) {
            $table->unsignedBigInteger('dep_id');

            $table->foreign('dep_id')->references('dep_id')->on('department');
        });
        Schema::table('result', function (Blueprint $table) {
            $table->unsignedBigInteger('course_id');

            $table->foreign('course_id')->references('course_id')->on('courses');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('result');
    }
};
