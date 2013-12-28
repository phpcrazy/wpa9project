<?php 

class MemberController extends BaseController {

	public function member_add(){			
		$validator = Validator::make(Input::all(), Config::get('validation.register'));

		if($validator->fails()) {
			return Redirect::route('member_list')->withInput()->withErrors($validator);	
		}

		$name = trim(Input::get('username'));

		if(Input::hasFile('profile')){
			$photo = Input::file('profile');
			$photoPath = '/uploads/'. $name . '.' . $photo->getClientOriginalExtension();

			try{
				$photo->move(public_path() . '/uploads/', $name . '.' . $photo->getClientOriginalExtension());
			}

			catch (Symfony\Component\HttpFoundation\File\Exception\FileException $e)
			{
				return Redirect::route('member_list')->withErrors(array('profile' => 'Photo size should not exceed more than 2mb.'));
			}
		}
		else{					
			$photoPath = '/uploads/'. $name . '.png';
			File::copy('img/profile.png','uploads/' . $name . '.png');
		}		

		$member=array(
			'orgId'		=>	Session::get('orgId'),
			'member'	=>	trim(Input::get('fullname')), 
			'address'	=>	trim(Input::get('address')),
			'phone'		=>	trim(Input::get('phone')),
			'photoPath'	=>	$photoPath);

		$memberId = Member::insertGetId($member);
		$user = Sentry::register(array(
			'orgId'	   => Session::get('orgId'),
			'username' => trim(Input::get('username')),
			'email'    => trim(Input::get('email')),
			'password' => trim(Input::get('password')),
			'memberId' => $memberId
		),true);

		$memberGroup = Sentry::findGroupByName('Member');
			$user->addGroup($memberGroup);

		return Redirect::route('member_list');		
	}		

	public function member_list() {			
		$members = DB::select('Select Member.memberId, Member.member, groups.name role, users.loginStatus from Member left join 
			( users left join ( users_groups join groups on users_groups.group_id = groups.id ) 
			on users.id = users_groups.user_id) on Member.memberId = users.memberId where Member.orgId = ? order by users_groups.group_id',array(Session::get('orgId')));

		$tasks = Task::where('orgId',Session::get('orgId'))->Select('task','assignTo','statusId')->join('TaskDetail', 'Task.taskId', '=', 'TaskDetail.taskId')->get();

		$roles = Role::select('name as role','id')->orderBy('id')->get();
		
		return View::make('partials/member_list')->with(array('members'=>$members, 'tasks'=>$tasks, 'roles'=>$roles));					

	}

	public function member_role_change() {		
		if(Input::get('pm_role_change')=='true'){					
			DB::table('users_groups')->where('users.orgId', Session::get('orgId'))
				->where('groups.name','PM')
				->join('users', 'users_groups.user_id', '=', 'users.id')
				->join('groups', 'users_groups.group_id', '=', 'groups.id')
				->update(array('users_groups.group_id'=>2));

			Session::put('role',2);
		}	

		DB::table('users_groups')->where('users.memberId', Input::get('memberId'))
					->join('users', 'users_groups.user_id', '=', 'users.id')
					->update(array('users_groups.group_id'=>Input::get('role')));

		return Redirect::route('member_list');	
	}

	public function member_delete() {		
		$userId = User::where('memberId',Input::get('memberId'))->pluck('id');

		DB::delete('delete from users_groups where user_Id=?',array($userId));

		User::where('memberId',Input::get('memberId'))->delete();

		Member::where('memberId',Input::get('memberId'))->delete();

		return Redirect::route('member_list');
	}

	public function member_detail() {	
		if(Input::get('memberId')!=null)
			$memberId = Input::get('memberId');	
		else
			$memberId = Input::old('memberId');

		$member = DB::select('Select Member.memberId, Member.member, Member.address, Member.phone, Member.photoPath, users.username, users.email, users.created_at, groups.name role from Member left join 
			( users left join ( users_groups join groups on users_groups.group_id = groups.id ) 
			on users.id = users_groups.user_id) on Member.memberId = users.memberId where Member.memberId = ?',array($memberId));		

		$members = DB::select('Select Member.memberId, Member.member from Member where Member.orgId = ?',array(Session::get('orgId')));

		return View::make('partials/member_detail')->with(array('members'=> $members,'member'=>$member));
	}

	public function member_update() {

		$memberId = Input::get('memberId');		
		$key	  = Input::get('key');
		$value    = Input::get('value');
		$url = '/member_detail/?memberId=' . $memberId;

		if(Input::hasFile('profile')){
			$name = $value;
			$photo = Input::file('profile');
			$photoPath = '/uploads/'. $name . '.' . $photo->getClientOriginalExtension();

			try{
				$photo->move(public_path() . '/uploads/', $name . '.' . $photo->getClientOriginalExtension());
				Member::where('memberId',$memberId)->update(array('photoPath'=>$photoPath));
				return Redirect::to($url);
			}

			catch (Symfony\Component\HttpFoundation\File\Exception\FileException $e)
			{
				return Redirect::to($url)->withErrors(array('profile' => 'Photo size should not exceed more than 2mb.'));
			}
		}	
				
		$field 	  = array(
			$key  => $value
		);
		
		$validator = Validator::make($field, Config::get('validation.member_update'));

		if($validator->fails()) {			
			return Redirect::to($url)->withErrors($validator);
		};
		$member = array('member'=>1,'address'=>2,'phone'=>3);		

		if(array_key_exists($key, $member)){
			Member::where('memberId',$memberId)->update(array($key=>$value));
			return Redirect::to($url);
		}
		if($key == 'password'){			
			$userId = User::where('memberId',$memberId)->pluck('id');
			$user = Sentry::findUserById($userId);
			$resetCode = $user->getResetPasswordCode();

			if ($user->checkResetPasswordCode($resetCode)){				
				if ($user->attemptResetPassword($resetCode, $value)){
					return Redirect::to($url);
				}				
			}				
		}

		User::where('memberId',$memberId)->update(array($key=>$value));

		return Redirect::to($url);
	}
}
