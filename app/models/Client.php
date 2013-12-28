<?php
class Client extends Eloquent
{	
	protected $table='Client';
	public $timestamps = false;

	public function project()
	{
		return $this->hasMany('Project');
	}

	public function organization()
	{
		return $this->belongsTo('Organization');
	}
}