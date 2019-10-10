<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBWorkbenchTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('b_workbench', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',30)->nullable(false);
            $table->string('number',30)->nullable(true);
            $table->string('email',30)->nullable(true);
            $table->string('website',30)->nullable(true);
            $table->string('address',100)->nullable(true);
            $table->string('street_address',100)->nullable(true);
            $table->string('zip',30)->nullable(true);
            $table->integer('country_id')->unsigned()->index('countries_country_id_foreign');
            $table->integer('state_id')->unsigned()->index('states_state_id_foreign');
            $table->integer('city_id')->unsigned()->index('cities_city_id_foreign');
            $table->text('claim_info')->nullable(true);
            $table->text('comments')->nullable(true);
            $table->text('risk_char')->nullable(true);
            $table->text('index_segment')->nullable(true);
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
        Schema::dropIfExists('b_workbench');
    }
}
