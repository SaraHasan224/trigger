<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_infos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->unsigned()->index('user_id_foreign');

            $table->string('holder_name',255)->nullable(true);
            $table->string('acc_num',255)->nullable(true);
            $table->string('iban_num',255)->nullable(true);
            $table->string('bank_name',199)->nullable(true);
            $table->string('bank_code',10)->nullable(true);

            $table->string('dc_name',199)->nullable(true);
            $table->string('dc_num',255)->nullable(true);
            $table->string('dc_exp',6)->nullable(true);
            $table->string('d_cvv',3)->nullable(true);

            $table->string('cc_name',199)->nullable(true);
            $table->string('cc_num',255)->nullable(true);
            $table->string('cc_exp',6)->nullable(true);
            $table->string('c_cvv',3)->nullable(true);

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
        Schema::dropIfExists('user_infos');
    }
}
