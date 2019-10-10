<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('records', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name',30)->nullable(false);
            $table->string('middle_name',30)->nullable(true);
            $table->string('last_name',30)->nullable(false);
            $table->string('dob',30)->nullable(false);
            $table->string('current_street',150)->nullable(true);
            $table->string('current_city',30)->nullable(false);
            $table->string('current_state',30)->nullable(false);
            $table->string('current_zip',20)->nullable(true);
            $table->string('old_street',30)->nullable(true);
            $table->string('old_city',30)->nullable(true);
            $table->string('old_state',30)->nullable(true);
            $table->string('old_zip',20)->nullable(true);
            $table->string('email')->nullable(false);
            $table->string('phone_no',40)->nullable(false);
            $table->string('current_emp',200)->nullable(true);
            $table->string('line_of_business',100)->nullable(true);
            $table->text('claim_desc')->nullable(true);
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
        Schema::dropIfExists('records');
    }
}
