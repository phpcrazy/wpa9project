<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Client', function(Blueprint $table)
		{
			//
			//$table->engine = 'InnoDB';
			$table->integer("orgId")->unsigned();
			$table->foreign("orgId")->references("orgId")->on("Organization");

			$table->increments("clientId")->unsigned();			
            $table->string("client")
                  ->nullable()
                  ->default(null);
            $table->string("address")->nullable()->default(null);
            $table->string("phone")->nullable()->default(null);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists("Client");
	}

}