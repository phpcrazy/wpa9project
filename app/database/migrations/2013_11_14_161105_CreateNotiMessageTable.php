<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotiMessageTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('NotiMessage', function(Blueprint $table)
		{
			$table->increments("messageId")->unsigned();
			$table->text("message");

			$table->integer("notiTypeId")->unsigned()->nullable()
                  ->default(null);
			$table->foreign("notiTypeId")->references("notiTypeId")->on("NotiType");
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('NotiMessage');
	}

}