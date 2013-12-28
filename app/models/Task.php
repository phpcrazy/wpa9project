<?php
class Task extends Eloquent
{
	protected $table='Task'; 
	public $timestamps = false;
	
	public function taskDetail()
	{
		return $this->hasMany('TaskDetail');
	}

	public function module()
	{
		return $this->belongsTo('Module');
	}

	public function member()
	{
		return $this->belongsTo('Member');
	}

	public function priority()
	{
		return $this->belongsTo('Priority');
	}

	public function organization()
	{
		return $this->belongsTo('Organization');
	}
}
