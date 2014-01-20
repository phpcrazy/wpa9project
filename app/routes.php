<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::any('/', array(
	'as'	=>	'login',
	'uses'  => 'UserController@loginAction'
));

Route::get('/logout', array(
	'as'	=> 'logout',
	'uses'	=> 'UserController@logoutAction'
));

Route::get('/register_first', array(
	'as' 	=> 'register_first',
	function(){
		return Redirect::route('register');
	}
));

Route::any('/register', array(
	'as' 	=> 'register',
	'uses' 	=> 'UserController@register'
));

Route::group(array('before' => 'auth|loginStatus'), function(){
	Route::any('org', array(		
		'as' 	=> 'add_org',
		'before'=> 'orgCheck',
		'uses' 	=> 'OrgController@organization'
	));

	Route::get('/member_list',array(
		'as'	=> 'member_list',
		'before'=> 'roleCheck',
		'uses'	=> 'MemberController@member_list'
	));

	Route::post('/add_member', array(
		'as'	=>	'add_member',
		'before'=>	'csrf',
		'uses'	=>	'MemberController@member_add'
	));

	Route::post('/member_delete', array(
		'as'	=>	'member_delete',
		'before'=>	'csrf',
		'uses'	=>	'MemberController@member_delete'
	));

	Route::post('/member_role_change', array(
		'as'	=>	'member_role_change',
		'before'=>	'csrf',
		'uses'	=>	'MemberController@member_role_change'
	));

	Route::get('/member_detail',array(
		'as'	=> 'member_detail',
		'uses'	=> 'MemberController@member_detail'
	));

	Route::post('/member_update',array(
		'as'	=> 'member_update',
		'before'=>	'csrf',
		'uses'	=> 'MemberController@member_update'
	));

	Route::get('/home', array(
		'as'	=> 'home',		
		'uses'	=> 'NotiController@notification'
	));	

	Route::post('/add_project', array(
		'as'	=>	'add_project',
		'before'=>	'csrf',
		'uses'	=>	'ProjectController@project_add'
	));

	Route::post('/add_client', array(
		'as'	=>	'add_client',
		'before'=>	'csrf',
		'uses'	=>	'ClientController@client_add'
	));

	Route::get('/project_list',array(
		'as'	=> 'project_list',
		'uses'	=> 'ProjectController@project_list'
	));

	Route::post('/project_deactivate',array(
		'as'	=> 'project_deactivate',
		'before'=>	'csrf',
		'uses'	=> 'ProjectController@project_deactivate'
	));

	Route::post('/project_delete',array(
		'as'	=> 'project_delete',
		'before'=>	'csrf',
		'uses'	=> 'ProjectController@project_delete'
	));

	Route::get('/project_detail',array(
		'as'	=> 'project_detail',
		'uses'	=> 'ProjectController@project_detail'
	));

	Route::post('/project_update',array(
		'as'	=> 'project_update',
		'before'=>	'csrf',
		'uses'	=> 'ProjectController@project_update'
	));	

	Route::post('/add_module', array(
		'as'	=>	'add_module',
		'before'=>	'csrf',
		'uses'	=>	'ModuleController@module_add'
	));

	Route::post('/module_update',array(
		'as'	=> 'module_update',
		'before'=>	'csrf',
		'uses'	=> 'ModuleController@module_update'
	));

	Route::post('/module_delete',array(
		'as'	=> 'module_delete',
		'before'=>	'csrf',
		'uses'	=> 'ModuleController@module_delete'
	));

	Route::get('/module_detail',array(
		'as'	=> 'module_detail',
		'uses'	=> 'ModuleController@module_detail'
	));

	Route::post('/add_tasklist', array(
		'as'	=>	'add_tasklist',
		'before'=>	'csrf',
		'uses'	=>	'TaskListController@tasklist_add'
	));

	Route::post('/tasklist_update',array(
		'as'	=> 'tasklist_update',
		'before'=>	'csrf',
		'uses'	=> 'TaskListController@tasklist_update'
	));

	Route::post('/tasklist_delete',array(
		'as'	=> 'tasklist_delete',
		'before'=>	'csrf',
		'uses'	=> 'TaskListController@tasklist_delete'
	));

	Route::get('/tasklist_detail',array(
		'as'	=> 'tasklist_detail',
		'uses'	=> 'TaskListController@tasklist_detail'
	));

	Route::post('/add_task', array(
		'as'	=>	'add_task',
		'before'=>	'csrf',
		'uses'	=>	'TaskController@task_add'
	));

	Route::post('/task_update',array(
		'as'	=> 'task_update',
		'before'=>	'csrf',
		'uses'	=> 'TaskController@task_update'
	));

	Route::post('/task_delete',array(
		'as'	=> 'task_delete',
		'before'=>	'csrf',
		'uses'	=> 'TaskController@task_delete'
	));

	Route::get('/workarea', array(
		'as'	=> 'workarea',		
		'uses'	=> 'TaskController@workarea'
	));	
});

Route::any('test', 'TaskController@workarea');
