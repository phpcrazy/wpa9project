<?php
class Role extends Eloquent
{
	protected $table='groups'; 
	public $timestamps = false;
	
	public function member()
	{
		return $this->hasMany('Member');
	}	
}
