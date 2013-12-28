<?php 

class UserController extends BaseController {

	public function loginAction()
	{	// firstly check user authenticated or not if yes, bypass to the home page
		if(!Sentry::check())
		{
			// if request made by get pass to the login page if by post, authenticate
			if(Request::server("REQUEST_METHOD")=="POST")
			{
				$validator = Validator::make(Input::all(), Config::get('validation.login'));

				if($validator->fails()) {					
					return Redirect::to('/')->withInput(Input::only('email'))->withErrors($validator);	
				}

				$credentials = array(
					'email' 		=> trim(Input::get('email')),
					'password' 		=> trim(Input::get('password'))					
				);
				$keepLogin;

				// if remember me check box is on, keep login the user even though browser close
				if(Input::get('keepLogin')==1)$keepLogin = true;
				else $keepLogin = false;
				
				$user = Sentry::authenticate($credentials,$keepLogin);					

				// to check login user is member or client
				$members = Member::where('id', $user->getId())
					->join('users','Member.memberId','=','users.memberId')
					->select('Member.memberId','Member.member','Member.photoPath')->get();

				if($members[0]->memberId){
					$type = 'member';
				}
				else $type = 'client';

				Session::put('userId',$user->getId());
				Session::put('memberId',$members[0]->memberId);
				Session::put('member',$members[0]->member);
				Session::put('photo',$members[0]->photoPath);
				// to check member or client
				Session::put('type', $type);

				$role = DB::table('users_groups')->where('user_id',$user->getId())->pluck('group_id');

				Session::put('role',$role);

				// to set user's login status
				User::where('id', Session::get('userId'))->update(array('loginStatus'=>'true'));

				// to check new user or regular user
				$orgId = User::where('id', $user->getId())->pluck('orgId');
				// if user's orgId field is not blank, it means regular user and redirect to home page
				if($orgId){
					Session::put('orgId', $orgId);
					return Redirect::route('home');
				}
				// if blank, it means user is first time registration and login, redirect to org registration page
				else{

					return Redirect::route('add_org');
				}

			}// firstly call the login 			
			return View::make("partials.login");

		}// if user keep login on, directly go the home page
		return View::make('hello');			
	}

	public function register() {
		if(Request::server("REQUEST_METHOD")=="POST")
		{
			$validator = Validator::make(Input::all(), Config::get('validation.register'));

			if($validator->fails()) {				
				return Redirect::route('register')->withInput()->withErrors($validator);

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
					return Redirect::route('register')->withErrors(array('profile' => 'Photo size should not exceed more than 2mb.'));
				}
			}
			else{					
				$photoPath = '/uploads/'. $name . '.png';
				File::copy('img/profile.png','uploads/' . $name . '.png');
			}

			$member=array(
				'member'	=>	trim(Input::get('fullname')), 
				'address'	=>	trim(Input::get('address')),
				'phone'		=>	trim(Input::get('phone')),
				'photoPath'	=>	$photoPath
			);

			$memberId = Member::insertGetId($member);
			$user = Sentry::register(array(
				'username' => trim(Input::get('username')),
				'email'    => trim(Input::get('email')),
				'password' => trim(Input::get('password')),
				'memberId' => $memberId
			),true);

			$adminGroup = Sentry::findGroupByName('PM');
			$user->addGroup($adminGroup);
							
			return Redirect::route('login')->withInput(Input::only('email','password'));
		}
		return View::make('partials.register');
	}

	public function logoutAction(){
		User::where('id', Session::get('userId'))->update(array('loginStatus'=>'false'));
		Sentry::logout();
		Session::flush();
		return Redirect::route('login');	
	}
}

 ?>