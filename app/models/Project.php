<?php
class Project extends Eloquent
{
	protected $table='Project'; 
	public $timestamps = false;

	public function module()
	{
		return $this->hasMany('Module');
	}

	public function client()
	{
		return $this->belongsTo('Client');
	}

	public function member()
	{
		return $this->belongsTo('Member');
	}

	public function organization()
	{
		return $this->belongsTo('Organization');
	}
}
