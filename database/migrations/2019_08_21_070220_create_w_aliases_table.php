<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWAliasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('w_aliases', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('workbench_id')->unsigned()->index('workbench_workbench_id_foreign');
            $table->string('first_name',30)->nullable(true);
            $table->string('middle_name',30)->nullable(true);
            $table->string('last_name',30)->nullable(true);
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
        Schema::dropIfExists('w_aliases');
    }
}
