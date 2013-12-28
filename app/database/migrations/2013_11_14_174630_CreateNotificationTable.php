<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Notification', function(Blueprint $table)
		{
			$table->integer("orgId")->unsigned()->nullable()
                  ->default(null);
			$table->foreign("orgId")->references("orgId")->on("Organization");

			$table->increments("notiId")->unsigned();			

			$table->string("source")
				  ->nullable()
				  ->default(null);		

			$table->string("field")
				  ->nullable()
				  ->default(null);	

			$table->integer("messageId")->unsigned()->nullable()
                  ->default(null);                  
			$table->foreign("messageId")->references("messageId")->on("NotiMessage");

			$table->dateTime("dateToNoti")
					->nullable()
					->default(null);

			$table->integer("createdBy")->nullable()
                  ->default(null);

			$table->dateTime("createdDate")
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
		Schema::dropIfExists('Notification');
	}
}