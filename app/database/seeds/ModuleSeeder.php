<?php
class ModuleSeeder extends Seeder {
 
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        $now = date('Y-m-d H:i:s');

    	$project_id = DB::table('Project')                                
                    ->where('project', 'PM_Project')
                    ->where('org', 'Myanmar Links')
                    ->join('Organization', 'Project.orgId', '=', 'Organization.orgId')
                    ->pluck('projectId');
                         
		DB::table('Module')->insert(array('module'=>'Design', 'dueDate'=>$now, 'projectId'=>$project_id));
	}
 
}
?>