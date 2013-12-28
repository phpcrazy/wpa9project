<?php

 
class GroupSeeder extends Seeder {
 
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
		DB::table('groups')->insert(array(
			'name'=>'PM',
			'permissions'=>'{"admin":1,"user":1}'
		));
		DB::table('groups')->insert(array(
			'name'=>'Department Head',
			'permissions'=>'{"admin":1,"user":1}'
		));
		DB::table('groups')->insert(array(
			'name'=>'Member',
			'permissions'=>'{"admin":1,"user":1}'
		));
	}
 
}
?>