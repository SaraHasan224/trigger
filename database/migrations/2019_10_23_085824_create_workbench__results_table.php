<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkbenchResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workbench__results', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('workbench_id')->unsigned()->index('workbench_workbench_id_foreign');
            $table->integer('source_options_id')->unsigned()->index('workbench_source_options_id_foreign');
            $table->float('score');
            $table->json('response');
            $table->json('result');
            $table->integer('type');
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
        Schema::dropIfExists('workbench__results');
    }
}
