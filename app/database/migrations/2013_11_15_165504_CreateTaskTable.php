<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Task', function(Blueprint $table)
		{						
			$table->integer("orgId")->unsigned()->nullable()
                  ->default(null);
			$table->foreign("orgId")->references("orgId")->on("Organization");
			
			$table->increments("taskId")->unsigned();

			$table->string("task")
				->nullable()
				->defaul(null);

			$table->integer("assignTo")->unsigned()->nullable()
                  ->default(null);
			$table->foreign("assignTo")->references("memberId")->on("Member");			
				
			$table->dateTime("startDate")
				->nullable()
				->default(null);			

			$table->dateTime("dueDate")
				->nullable()
				->default(null);

			$table->integer("priorityId")->unsigned()->nullable()
                  ->default(null);
			$table->foreign("priorityId")->references("priorityId")->on("Priority");		

			$table->integer("taskListId")->unsigned()->nullable()
                  ->default(null);
			$table->foreign("tasklistId")->references("tasklistId")->on("TaskList");	

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists("Task");
	}

}