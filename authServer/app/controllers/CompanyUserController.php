<?php
include 'send.php';
class CompanyUserController extends \BaseController {


	public function __construct()
    {
        $this->beforeFilter('user.admin', array('only' => 'getCheckApplier'));
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$company_id = Input::get('id');
		$user_id = Auth::user()->id;
		$companyUserInfo = CompanyUser::isCompanyAdmin($user_id, $company_id);

		if($companyUserInfo != null){
			return Redirect::to('manage');
		}
		else{
			return View::make('company.applyAdmin', array('company_id' => $company_id));
		}

	}

	public function getCheckApplier(){
		if ('sysadmin' != Auth::user()->username && 'admin' != Auth::user()->username)
		{
			return Response::json(array('result'=>'failed','error_msg'=>'You do not have access to this page'));
		}
		$state = Input::get('state');

		if(!isset($state)){
			$state = 0;
		}

		$adminApplies = AdminApply::getAppliesByState($state);

		foreach($adminApplies as $adminApply){
			$user = User::find($adminApply->user_id);
			$company = Company::find($adminApply->company_id);
			$applyInfo[] = array(
				'applyId' => $adminApply->id,
				'userId' => $user->id,
				'userName' => $user->username,
				'userEmail' => $user->email,
				'companyId' => $company->id,
				'companyName' => $company->name,
				'companyEmail' => $company->email,
				'reason' => $adminApply->reason,
				'state'	=> $state,
			);
		}
		if(!isset($applyInfo)){
			$applyInfo[] = array();
		}
		return View::make('company.checkAdmin', array('nav_active' => 'applier', 'applyInfo' => $applyInfo, 'state' => $state));
	}

	/**
	 * 审核组织管理员
	 */
	public function checkApplyAdmin() {
		$state = Input::get('state');
		$applyId = Input::get('applyId');

		switch($state){
			case 1:
				AdminApply::updateState($applyId, $state);

				//改变companyUsers表中相对应的用户类型
				$adminApply = AdminApply::find($applyId);
				CompanyUser::setAdmin($adminApply->user_id, $adminApply->company_id, $state, 1);
				$applier_name = DB::table('users')->where('id',$adminApply->user_id)->first();
				$companyapply = DB::table('company')->where('id',$adminApply->company_id)->first();
				send2rabbitmq('localhost', 'secfile', '{"action":"ApplyAdmin","company_id":'.$adminApply->company_id.',"company_name":"'.$companyapply->name.'","applier_email":"'.$applier_name->email.'"}');
				break;
			case 2:
				AdminApply::updateState($applyId, $state);
				break;
		}

		$ret = array('result'=>'success') ;

		return Response::json($ret);

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)//转至企业通讯录
	{
//		$company =  Company::find($id);
//		$companyUsers = $company->companyUser;

		$companyUsers = CompanyUser::getAllUserByCmpId($id);
		$companyUsersE = CompanyUser::getAllUserByCmpId2($id);
		$dname = '';
		foreach($companyUsers as $companyUser){
		$ugroup = DB::table('project_group_member')
                ->join('project_group', 'project_group.id', '=', 'project_group_member.project_group_id')
                ->where('project_group_member.user_id', $companyUser->user_id)
				->select('name')->get();
		$arr = array();
		foreach ($ugroup as $k => $v) {
			
			$arr[] = $v->name;
		}
		$gp = implode("|", $arr);
		$tp = User::find($companyUser->user_id);
		$tp->group_name = $gp;
		$allUser[] = $tp;

		}
		if(!isset($allUser)){
			$allUser = -1;
		}
		
		//print_r($allUser[0]['username']);
		return View::make('company.contacts', array('id' => $id, 'type' => 1, 'dname' => $dname,'allUser' => $allUser, 'companyUsers' => $companyUsers));
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	public function postApplyAdmin(){

		$reason = Input::get('reason');
		$company_id = Input::get('company_id');
		$user_id = Auth::user()->id;

		$adminApply = AdminApply::getApply($user_id, $company_id);
		if($adminApply != null){

			switch($adminApply->state){
				case 0:
					return Redirect::action('CompanyController@show')
						->with('success','申请成功，请耐心等待管理员审核');
				case 1:
					return Redirect::action('CompanyController@show')
						->with('success','您已经是该组织的管理员,如有疑问,请联系系统管理员');
				case 2:
					AdminApply::updateApply($adminApply->id, $reason, 0);
					return Redirect::action('CompanyController@show')
						->with('success','申请成功，请耐心等待管理员审核');
			}

		}

		$applyInfo = array(
			'company_id' => $company_id,
			'user_id' 	 => $user_id,
			'reason'	 => $reason,
		);

		$apply = new AdminApply($applyInfo);
		if($apply->save(AdminApply::$rules)){
			return Redirect::action('CompanyController@show')
				->with('success','申请成功，请耐心等待管理员审核');
		}

		return View::make('company.applyAdmin', array('company_id' => $company_id))
				->with('warning', '申请失败，请稍后尝试');
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
    public function destroy($id){
      $userId = Auth::user()->id;
      $companyId = $id;
      $companyAdmin =  DB::table('company_users')->where('user_id',$userId)->where('company_id',$companyId)->pluck('type');
      if ($companyAdmin != 1 ) {
         CompanyUser::deleteCmpUser($userId, $companyId);

         $user = User::find($userId);

         //组织关系修改, 发送消息到队列
         $exchange = 'org';
         $routeKey = 'org.change';
         $message = '{"email":"' . strtolower($user->email) . '", "company_id":"' . $companyId . '", "message":"the relation of organization has changed"}';
         $company_name = DB::table('company')->where('id', $companyId)->first();
         send2rabbitmq('localhost', 'secfile', '{"action":"ExitCompany","company_id":' . $companyId . ',"company_name":"' . $company_name->name . '","email":"' . $user->email . '"}');
         RabbitMQ::publish($exchange, $routeKey, $message);
      	return Redirect::route('company.show');
      }
//    $companyUser = CompanyUser::find($userId);
//        $companyUser->delete();
      return Redirect::route('company.show')->with("error", "创建人不能退出！");

   }


}
