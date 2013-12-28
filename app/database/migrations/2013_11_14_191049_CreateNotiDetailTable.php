<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotiDetailTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('NotiDetail', function(Blueprint $table)
		{

			$table->integer("notiId")->unsigned();
			$table->foreign("notiId")->references("notiId")->on("Notification");

			$table->integer("notiTo")->unsigned();
			$table->foreign("notiTo")->references("memberId")->on("Member");
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('NotiDetail');
	}

}