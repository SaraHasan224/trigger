<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonalResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personal_results', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('workbench__results_id')->unsigned()->index('workbench_workbench__results_id_foreign');
            $table->json('name')->nullable(true);
            $table->json('email')->nullable(true);
            $table->json('age')->nullable(true);
            $table->json('gender')->nullable(true);
            $table->json('language')->nullable(true);
            $table->json('dob')->nullable(true);
            $table->json('avatar')->nullable(true);
            $table->json('bio')->nullable(true);
            $table->json('site')->nullable(true);
            $table->json('phone_number')->nullable(true);
            $table->json('images')->nullable(true);
            $table->json('urls')->nullable(true);
            $table->json('ethnicity')->nullable(true);
            $table->json('origin_country')->nullable(true);
            $table->json('relations')->nullable(true);
            $table->json('location')->nullable(true);
            $table->json('longitude')->nullable(true);
            $table->json('latitude')->nullable(true);
            $table->json('state')->nullable(true);
            $table->json('city')->nullable(true);
            $table->json('country')->nullable(true);
            $table->json('zip_code')->nullable(true);
            $table->json('timezone')->nullable(true);
            $table->json('career')->nullable(true);
            $table->json('education')->nullable(true);
            $table->json('social')->nullable(true);
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
        Schema::dropIfExists('personal_results');
    }
}
