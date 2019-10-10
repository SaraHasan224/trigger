<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('w_address', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('workbench_id')->unsigned()->index('workbench_workbench_id_foreign');
            $table->string('street',150)->nullable(true);
            $table->integer('country_id')->unsigned()->index('countries_country_id_foreign');
            $table->integer('state_id')->unsigned()->index('states_state_id_foreign');
            $table->integer('city_id')->unsigned()->index('cities_city_id_foreign');
            $table->string('zip',30)->nullable(true);
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
        Schema::dropIfExists('w_address');
    }
}
