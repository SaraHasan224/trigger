<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('to_type', FALSE, TRUE)->default(1);
            $table->integer('to_id', FALSE, TRUE)->index('users_id_foreign');
            $table->integer('from_type', FALSE, TRUE)->default(1);
            $table->integer('from_id', FALSE, TRUE)->index('users_id_foreign');
            $table->text('message');
            $table->string('link',199)->default(null);
            $table->string('class',199)->default(null);
            $table->string('icon',199)->default(null);
            $table->tinyInteger('is_read')->default(0);
            $table->tinyInteger('is_sadmin_read')->default(0);
            $table->timestamp('dated')->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
