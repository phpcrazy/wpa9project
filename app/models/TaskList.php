<?php
class TaskList extends Eloquent{

	protected $table='TaskList';
	public $timestamps = false;
	
	public function Module()
	{
 		return $this->belongsTo('Module');
	}

	public function Task()
	{
 		return $this->hasMany('Task');
	}
}