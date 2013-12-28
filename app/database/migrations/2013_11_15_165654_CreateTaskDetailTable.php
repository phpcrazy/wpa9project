<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskDetailTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('TaskDetail', function(Blueprint $table)
		{
			$table->integer("taskId")->unsigned();
			$table->foreign("taskId")->references("taskId")->on("Task");

			$table->text("desc")
				->nullable()
				->defaul(null);

			$table->integer("statusId")->unsigned()->default(1);
			$table->foreign("statusId")->references("statusId")->on("Status");		

			$table->string("remark")
				->nullable()
				->defaul(null);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists("TaskDetail");
	}

}