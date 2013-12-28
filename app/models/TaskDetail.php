<?php
class TaskDetail extends Eloquent
{
	protected $table='TaskDetail'; 
	public $timestamps = false;

	public function task()
	{
		return $this->belongsTo('Task');
	}

	public function status()
	{
		return $this->belongsTo('Status');
	}	
}
