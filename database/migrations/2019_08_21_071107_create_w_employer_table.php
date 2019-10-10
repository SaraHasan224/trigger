<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWEmployerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('w_employer', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('workbench_id')->unsigned()->index('workbench_workbench_id_foreign');
            $table->string('name',30)->nullable(true);
            $table->string('job_title',30)->nullable(true);
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
        Schema::dropIfExists('w_employer');
    }
}
