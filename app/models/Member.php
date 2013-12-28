<?php
class Member extends Eloquent
{
	protected $table='Member'; 
	public $timestamps = false;

	public function project()
	{
		return $this->hasMany('Member');
	}	

	public function organization()
	{
		return $this->belongsTo('Organization');
	}
}