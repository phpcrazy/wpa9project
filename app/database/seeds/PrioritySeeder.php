<?php

class PrioritySeeder extends Seeder {
 
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
    	
		DB::table('Priority')->insert(array('priority'=>'Low'));
        DB::table('Priority')->insert(array('priority'=>'Medium'));
        DB::table('Priority')->insert(array('priority'=>'High'));
	}
 
}
?>