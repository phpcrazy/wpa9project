<?php 

class OrgController extends BaseController {

	public function organization(){			
		if(Request::server("REQUEST_METHOD")=="POST"){

			$validator = Validator::make(Input::all(), Config::get('validation.org'));

			if($validator->fails()) {
				return Redirect::route('add_org')->withErrors($validator);	
			}

			$org = array('org' => trim(Input::get('org')));

			$orgId = Organization::insertGetId($org);

			User::where('id', Session::get('userId'))->update(array('orgId'=>$orgId));
			Member::where('id', Session::get('userId'))
				->join('users', 'Member.memberId', '=', 'users.memberId')
				->update(array('Member.orgId'=>$orgId));
			
			Session::put('orgId', $orgId);				

			return Redirect::route('member_list');
		}
		return View::make("partials.add_org");	
			
	}		
}
