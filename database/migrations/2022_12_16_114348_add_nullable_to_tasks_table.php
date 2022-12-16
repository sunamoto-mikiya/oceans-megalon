<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->change();
            $table->dropForeign('tasks_user_id_foreign');
            $table->foreign('user_id')->references('id')->on('users');
            $table->text('description')->nullable()->change();
            $table->date('start_date')->nullable()->change();
            $table->date('end_date')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->change();
            $table->dropForeign('tasks_user_id_foreign');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->text('description')->change();
            $table->date('start_date')->change();
            $table->date('end_date')->change();
        });
    }
};
