<?php
	return array(
		'title'	=> array(
			'login'								=> 'Login Form',
			'register'							=> 'Registeration Form',
			'add_org'							=> 'Organization Register Form',
			'add_member'						=> 'Member Registration Form',
			'add_client'						=> 'Client Register Form',
			'add_project'						=> 'Project Registration Form',
			'add_module'						=> 'Module Register Form',
			'add_tasklist'						=> 'Task List Registration Form',
			'add_task'							=> 'Task Registration Form',
			'confirm_member_delete'				=> 'Confirm Member Delete',
			'confirm_project_delete'			=> 'Confirm Project Delete',
			'confirm_module_delete'				=> 'Confirm Module Delete',
			'confirm_tasklist_delete'			=> 'Confirm Task List Delete',
			'confirm_task_delete'				=> 'Confirm Task Delete',
			'confirm_project_authority_change'	=> 'Confirm Project Authority Change',
			'confirm_project_deactivate'		=> 'Confirm Project Deactivation',
			'confirm_project_rename'			=> 'Confirm Project Rename',
			'confirm_member_role_change'		=> 'Confirm Member Role Change',
			'home'				=> array(
				'main'				=> 'Dashboard',
				'notification'		=> 'Notification',
				'description'	=> 'Description'
			),
			'member_list'		=> array(
				'main'				=> 'Members',
				'member_list'		=> 'Member List',
			),
			'member_detail'				=> 'Detail Information of',
			'project_list'				=> 'Projects',
			'project_detail'	=> array(
				'main' 				=> 'Details of Project',
				'module_area'		=> 'Modules',
				'event'				=> 'Events'
			),			
			'module_detail'	=> array(
				'main' 				=> 'Details of Module',
				'tasklist_area'		=> 'Task Lists'				
			),
			'tasklist_detail'	=> array(
				'main' 				=> 'Details of Task List',
				'task_area'			=> 'Tasks'				
			),
			'task_detail'				=> 'Details of Task',						
			'workarea'					=> 'Work Area',	
		),
		'label' 	=> array(
			'login'		=> array(
				'email'		=> 'Email',
				'password'	=> 'Password',
				'r_me'		=> 'Remember Me'
			),
			'register'	=> array(
				'photo_warn'	=> 'max-2mb',
				'member_name'	=> 'member Name',								
				'ph'			=> 'phone',
				'add'			=> 'address',
				'username'		=> 'username',
				'email'			=> 'email address',
				'pass'			=> 'password',
				'c_pass'		=> 'confirmed password'
			),
			'add_org'	 => array(
				'org'		=> 'Your Organization Name'		
			),
			'add_client' => array(
				'clientname'=> 'Full Name or Company Name',
				'email'		=> 'Email Address',
				'pass'	=> 'Password',
				'add'		=> 'Address',
				'ph'		=> 'Phone'		
			),
			'add_project' => array(
				'projectname'	=> 'Project Name',
				'desc'			=> 'Project Description',
				'start_date'	=> 'Pick Start Date',
				'due_date'		=> 'Pick Due Date',
				'client'		=> 'Please Choose Client Name'		
			),
			'add_module' => array(
				'modulename'	=> 'Module Name',
				'desc'			=> 'Module Description',
				'start_date'	=> 'Pick Start Date',
				'due_date'		=> 'Pick Due Date'		
			),
			'add_tasklist' => array(
				'tasklistname'	=> 'Task List Name',
				'desc'			=> 'Task List Description',
				'start_date'	=> 'Pick Start Date',
				'due_date'		=> 'Pick Due Date'		
			),
			'add_task' => array(
				'lbtaskname'	=> 'Task Name',
				'lbdesc'		=> 'Description',
				'lbassigned'	=> 'Assigned To',
				'lbstart_date'	=> 'Start Date',
				'lbdue_date'	=> 'Due Date',
				'lbpriority'	=> 'Priority',
				'taskname'		=> 'Task Name',
				'desc'			=> 'Task Description',
				'assigned'		=> 'Please Choose',
				'start_date'	=> 'Pick Start Date',
				'due_date'		=> 'Pick Due Date'	
			),	
			'confirm_member_delete'	=> 'You are about to delete this member. Are you sure you want to do this?',
			'confirm_member_role_change'	=> "You are about to change role of this member to PM. You'll be losing your position as a PM",
			'confirm_project_delete'	=> 'You are about to delete this project. The project will be available for view only in the future. You can not change back the project to be active again.',			
			'confirm_project_deactivate'	=> 'You are about to deactivate this project. You will need to reset every start date and due date fields related with the project.',
			'confirm_project_rename'	=> 'You are about to rename the project. Are you sure you want to do this?',
			'confirm_project_authority_change'	=> 'You are about to deliver authority of this project to other. You can no longer control the project.',
			'confirm_module_delete'	=> 'You are about to delete this module and its related parts. Are you sure you want to do this?',
			'confirm_tasklist_delete'	=> 'You are about to delete this Tasklist and its related parts. Are you sure you want to do this?',
			'confirm_task_delete'	=> 'You are about to delete this Task. Are you sure you want to do this?',	
			'member_list'	=> array(
				'member_name'	=> 'Member Name',
				'status'		=> 'Status',
				'action'		=> 'Action'
			),
			'member_detail'	=> array(
				'photo_warn'	=> 'max-2mb',
				'member_name'	=> 'Member Name',
				'role'			=> 'Role',
				'j_date'		=> 'Joined date',
				'ph'			=> 'Phone',
				'add'			=> 'Address',
				'username'		=> 'Username',
				'email'			=> 'Email Address',
				'pass'			=> 'Password',
				'c_pass'		=> 'Confirmed Password'
			),
			'detail' => array(
				'proj_name'		=> 'Project Name',
				'mod_name'		=> 'Module Name',
				'tasklist_name'	=> 'Task List Name',
				'task_name'		=> 'Task Name',
				'desc'			=> 'Description',
				's_date'		=> 'Start Date',
				'd_date'		=> 'Due Date',
				'a_by'			=> 'Authorized By',
				'status'		=> 'Status',
				'progress'		=> 'Progress',
				'action'		=> 'Action',
				'a_to'		=> 'Assigned To',
				'priority'		=> 'Priority',
				'per_page'		=> 'Per Page'
			),
		),
		'link' 	=> array(
			'button'=> array(
				'browse'	  => 'Browse',
				'register'	  => 'Register',
				'login'	  	  => 'Log In',
				'create'	  => 'Create',
				'edit'		  => 'Edit',
				'add_proj'	  => 'Create Project',
				'add_client'  => 'Add Client',
				'add_mod'	  => 'Add New Module',
				'add_tasklist'=> 'Add New Task List',
				'add_task'	  => 'Add Task',
				'add_mem'	  => 'Add New Member',
				'yes'	  	  => 'Yes',
				'no'	  	  => 'No'
			),
			'link'=> array(
				'forgot_pass' => 'Forgot Password?',
				'sign_up'	  => 'Sign Up',
				'rename'	  => 'Rename',
				'delete'	  => 'Delete',
				'deactivate'	  	  => 'Deactivate',
				'delegate'	  => 'Delegate To',
				'ch_client'		  => 'Change Client',
				'add_proj'	  => 'Create Project',
				'add_client'  => 'Add Client',
				'add_mod'	  => 'Add New Module',
				'add_tasklist'=> 'Add Task List',
				'add_task'	  => 'Add Task',
				'add_mem'	  => 'Add New Member',
				'yes'	  	  => 'Yes',
				'no'	  	  => 'No'
			),
			'sidebar'=>array(
				'dash'  => 'Dashboard',
				'proj'	  => 'Projects',
				'work_area'=> 'Work Area',
				'mem'	  => 'Members',
				'progress'	  => 'Progress'	
			),
			'top_nav'=>array(
				'setting'  	   => 'Setting',
				'acc_setting'  => 'Account Setting',
				'org_setting'  => 'Organization Setting',
				'logout'	   => 'Log Out'	
			),
		),
	);
?>