<?php

return array(

	'login'		=> array(
		'email'					=> 'required',
		'password'				=> 'required|min:4',
	),
	'register'	=> array(
		'username'				=> 'required|unique:users',
		'email'					=> 'required|email|unique:users',
		'password'				=> 'required|min:4|confirmed',
		'password_confirmation'	=> 'required|min:4',
		'fullname'				=> 'required',
		'profile'				=> 'image|max:2000',
	),
	'org'		=> array(
		'org'					=> 'required',
	),
	'client'	=> array(
		'clientname'			=> 'required',
		'email'					=> 'required|email|unique:users',
		'password'				=> 'required|min:4',
	),
	'project'	=> array(
		'projectname'			=> 'required',
		'startDate'				=> 'required',
		'dueDate'					=> 'required',
	),
	'module'	=> array(
		'modulename' 			=> 'required',
		'startDate'				=> 'required',
		'dueDate'  			 		=> 'required',
	),
	'tasklist'	=> array(
		'tasklistname' 			=> 'required',
		'startDate'				=> 'required',
		'dueDate'  			 		=> 'required',
	),
	'task'	=> array(
		'taskname'		 		=> 'required',
		'startDate'				=> 'required',
		'dueDate'  			 		=> 'required',
	),
	'member_update'=>array(
		'username' 				=> 'unique:users',
		'email'			    	=> 'email|unique:users',
	)
);	