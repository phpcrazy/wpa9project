<?php
class Notification extends Eloquent
{
	protected $table='Notification'; 
	// public $timestamps = false;

	public function notiDetail()
	{
		return $this->hasMany('NotificationDetail');
	}

	public function notiType()
	{
		return $this->belongsTo('NotiType');
	}

	public function notiMessage()
	{
		return $this->belongsTo('NotiMessage');
	}

	public function organization()
	{
		return $this->belongsTo('Organization');
	}
}
