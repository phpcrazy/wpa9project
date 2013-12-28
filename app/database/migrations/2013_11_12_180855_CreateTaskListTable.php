<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
    
class CreateTaskListTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('TaskList', function(Blueprint $table)
		{
			
			$table->increments("tasklistId")->unsigned();

            $table->string("tasklist")
                  ->nullable()
                  ->default(null);

            $table->string("desc")
                  ->nullable()
                  ->default(null);

            $table->dateTime("startDate")  
     			  ->nullable()
				  ->default(null);

            $table->dateTime("dueDate")  
     			  ->nullable()
				  ->default(null);

			$table->string("status")       			  
				  ->default("Just Start");

            $table->integer("moduleId")->unsigned()->nullable()
                  ->default(null);

			$table->foreign("moduleId")->references("moduleId")->on("Module");

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists("TaskList");
	}

}