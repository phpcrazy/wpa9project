<?php 

class ClientController extends BaseController {

	public function client_add(){			
		$validator = Validator::make(Input::all(), Config::get('validation.client'));

		if($validator->fails()) {
			return Redirect::route('home')->withInput()->withErrors($validator);	
		}

		$client=array(
			'orgId'		=>	Session::get('orgId'),
			'client'	=>	trim(Input::get('clientname')), 
			'address'	=>	trim(Input::get('address')),
			'phone'		=>	trim(Input::get('phone'))
		);

		$clientId = Client::insertGetId($client);
		$user = Sentry::register(array(
			'orgId'	   => Session::get('orgId'),
			'username' => trim(Input::get('email')),
			'email'    => trim(Input::get('email')),
			'password' => trim(Input::get('password')),
			'clientId' => $clientId
		),true);

		return Redirect::route('home');		
	}		
}
