<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotiTypeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('NotiType', function(Blueprint $table)
		{
			$table->increments("notiTypeId")->unsigned();

			$table->string("notiType")
					->nullable()
					->default(null);
			});
	}
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('NotiType');
	}

}