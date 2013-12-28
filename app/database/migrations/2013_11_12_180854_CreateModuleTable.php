<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModuleTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Module', function(Blueprint $table)
		{
			$table->increments("moduleId")->unsigned();

            $table->string("module")
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

			$table->integer("active")       			  
				  ->default(0);

            $table->integer("projectId")->unsigned()->nullable()
                  ->default(null);

			$table->foreign("projectId")->references("projectId")->on("Project");

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists("Module");
	}

}