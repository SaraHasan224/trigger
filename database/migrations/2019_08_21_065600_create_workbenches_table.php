<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkbenchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workbenches', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name',30)->nullable(false);
            $table->string('middle_name',30)->nullable(true);
            $table->string('last_name',30)->nullable(false);
            $table->string('dob',30)->nullable(true);
            $table->string('email',150)->nullable(false);
            $table->string('street',199)->nullable(true);
            $table->string('city',30)->nullable(true);
            $table->string('state',30)->nullable(true);
            $table->string('country',30)->nullable('US');
            $table->string('zip',30)->nullable(true);
            $table->string('current_emp',200)->nullable(true);
            $table->string('job_title',150)->nullable(true);
            $table->text('comment')->nullable(true);
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
        Schema::dropIfExists('workbenches');
    }
}
