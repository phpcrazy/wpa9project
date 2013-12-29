<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		// Eloquent::unguard();

		// $this->call('OrganizationSeeder');
		$this->call('GroupSeeder');
		// $this->call('ClientSeeder');
		// $this->call('MemberSeeder');
		// $this->call('ProjectSeeder');
		// $this->call('ModuleSeeder');
		// $this->call('TaskListSeeder');
		$this->call('PrioritySeeder');
		$this->call('StatusSeeder');
		// $this->call('TaskSeeder');
		// $this->call('TaskDetailSeeder');
		$this->call('NotiTypeSeeder');
		$this->call('NotiMessageSeeder');
		// $this->call('NotificationSeeder');
		// $this->call('NotificationDetailSeeder');
	}
}


