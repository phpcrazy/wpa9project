<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Member', function(Blueprint $table)
		{
			$table->integer("orgId")->unsigned()->nullable()
                  ->default(null);
			$table->foreign("orgId")->references("orgId")->on("Organization");			

			$table->increments("memberId")->unsigned();;			
            $table->string("member")->nullable()->default(null);            
            $table->string("address")->nullable()->default(null);
            $table->string("phone")->nullable()->default(null);
            $table->string('photoPath')->nullable()->default(null);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists("Member");
	}

}