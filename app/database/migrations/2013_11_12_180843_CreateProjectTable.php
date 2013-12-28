<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Project', function(Blueprint $table)
		{
			$table->integer("orgId")->unsigned();
			$table->foreign("orgId")->references("orgId")->on("Organization");

			$table->increments("projectId")->unsigned();

            $table->string("project")
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
				                		  
            $table->integer("authorizedBy")->unsigned()->nullable()
                  ->default(null);
			$table->foreign("authorizedBy")->references("memberId")->on("Member");

			$table->integer("clientId")->unsigned()->nullable()
                  ->default(null);
			$table->foreign("clientId")->references("clientId")->on("Client");

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists("Project");
	}

}