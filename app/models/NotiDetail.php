<?php
class NotiDetail extends Eloquent
{
	protected $table='NotiDetail'; 
	public $timestamps = false;

	public function notification()
	{
		return $this->belongsTo('Notification');
	}

	public function member()
	{
		return $this->belongsTo('Member');
	}
	
}
