<?php

class NotiMessageSeeder extends Seeder {
 
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){

		NotiMessage::insert(array('message'=>'? create a ?','notiTypeId'=>1));        
		NotiMessage::insert(array('message'=>'? update a ? of ?','notiTypeId'=>1));        
		NotiMessage::insert(array('message'=>'? delete a ?','notiTypeId'=>1));
		NotiMessage::insert(array('message'=>'? assign a task : ? to ?','notiTypeId'=>1));         
		NotiMessage::insert(array('message'=>'? reach ? days before due date','notiTypeId'=>2));        
		NotiMessage::insert(array('message'=>'? reach due date','notiTypeId'=>2));        
		NotiMessage::insert(array('message'=>'? ? a task','notiTypeId'=>3));        
	}
 
}
?>