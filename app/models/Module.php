
<?php
class Module extends Eloquent{

	protected $table='Module';
	public $timestamps = false;
	
	public function Project()
	{
 		return $this->belongsTo('Project');
	}
	
	public function TaskList()
	{
 		return $this->hasMany('TaskList');
	}
}