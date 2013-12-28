<?php
class TaskListSeeder extends Seeder {
 
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        $now = date('Y-m-d H:i:s');

    	$mod_id = DB::table('Module')                                
                    ->where('module', 'Design')
                    ->pluck('moduleId');
                         
		DB::table('TaskList')->insert(array('tasklist'=>'Testing', 'startDate'=>$now, 'dueDate'=>$now, 'moduleId'=>$mod_id));
	}
 
}
?>