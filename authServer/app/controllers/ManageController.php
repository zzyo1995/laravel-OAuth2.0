<?php
include 'send.php';
class ManageController extends BaseController {

    public function __construct()
    {
        $this->beforeFilter('user.manage');
    }

    public function home()
    {
        return View::make('manage.home', array('nav_active' => "home"));//转向manage的管理页面
    }

    public function users()
    {

        $allUsers = User::all();//提取用户信息
        $activeUserRecs = ActiveUser::all();//提取在线用户信息
        $activeUsers = array();
        //$clientActiveUsers = User::getClientActiveUsers() ;// 获取客户端在线用户信息

        foreach ($activeUserRecs as $auc) {
            $activeUsers[] = $auc->user;
        }

        return View::make('manage.user', array('nav_active' => "users", 'all' => $allUsers, 'active' => $activeUsers));
    }

    public function getCompanies(){

        $userId = Auth::user()->id;
        $companyUsers = CompanyUser::getCompanyUserByUserId($userId);

        foreach($companyUsers as $eachCompanyUser){
            $company = Company::find($eachCompanyUser->company_id);
            $companies[] = $company;
        }

        if(!isset($companies)) {

            $companies[] = null;
        }

        return View::make('manage.companies', array('nav_active' => 'companies', 'companies' => $companies));

    }

    /**
     * 查询所有组织成员
     */
    public function allUser($id){

        $company_id = $id;

//        $companyUsers = CompanyUser::getAllUserByCmpId($company_id);
        $companyUsers = CompanyUser::getAllUserByCmpId($company_id);
        foreach($companyUsers as $eachCompanyUser){
			$user = User::find($eachCompanyUser->user_id);
			$user->type = $eachCompanyUser->type;
			$user->reason = DB::table('company_users')->where('user_id', $user->id)->where('company_id', $company_id)->pluck('reason');
			$user->category_description = DB::table('oauth_roles')->where('name', $user->user_category)->pluck('description');
            $users[] = $user;
        }
        if(!isset($users)){
            $users[] = array();
        }

        $company = Company::find($company_id);

        return View::make('manage.allUser', array('nav_active' => 'companies', 'users' => $users, 'company' => $company, 'companyUsers' => $companyUsers));

    }
    
	public function companyUserSearch(){
		$companyId = Input::get('id');
		$userName = Input::get('name');
		
		$users = CompanyUser::getAllUserByCon2($userName, $companyId, 1);
		
		foreach($users as $user) {
			$user->category_description = DB::table('oauth_roles')->where('name', $user->user_category)->pluck('description');
		}
		if(!isset($users)){
            $users[] = array();
        }
        
		if(!isset($companyUsers)){
            $companyUsers = array();
        }

        $company = Company::find($companyId);
        return View::make('manage.allUser', array('nav_active' => 'companies', 'users' => $users, 'company' => $company, 'companyUsers' => $companyUsers));
	}

    /**
     * 点击导航链接到审核页面
     */
    public function check(){
        $input = Input::all() ;

        switch($input['state'])
        {
            case "undo":
                $input['state'] = 0 ;
                break ;
            case "success":
                $input['state'] = 1 ;
                break ;
            case "fail":
                $input['state'] = 2 ;
                break ;
        }

        $user = User::getUserInfoByEmail($input['email']);
        $company_id = $input['company_id'];

        if($user != null && isset($input['state'])){
            if(CompanyUser::updateStateByCondition($user[0]->id, $company_id, $input['state'],$input['reason'])){
		$company_name = DB::table('company')->where('id',$company_id)->first();
		send2rabbitmq('localhost', 'secfile', '{"action":"AddToCompany","email":"'.$input['email'].'","company->id":'.$company_id.',"reason":"'.$input['reason'].'","company_name":"'.$company_name->name.'"}');
                $ret = array('result'=>'success') ;
                return Response::json($ret) ;
            }
        }

    }


    public function deleteUser(){
        $user_id = Input::get('user_id');
        $company_id = Input::get('company_id');

        if(CompanyUser::deleteCmpUser($user_id, $company_id)){
            $ret = array('result' => 'success');
	    $useremail = DB::table('users')->where('id',$user_id)->first();
		$company_name = DB::table('company')->where('id',$company_id)->first();
	    send2rabbitmq('localhost', 'secfile', '{"action":"ExitCompany","company_id":'.$company_id.',"company_name":"'.$company_name->name.'","email":"'.$useremail->email.'"}');
            return Response::json($ret);
        }

        $user = User::find($user_id);

        //组织关系修改, 发送消息到队列
        $exchange = 'org';
        $routeKey = 'org.change.'.$company_id;
        $message = '{"type":2_1, "email":"'.strtolower($user->email).'", "group_id":"", "company_id":"'.$company_id.'", "message":"the member has been deleted"}';

        RabbitMQ::publish($exchange, $routeKey, $message);

    }


    public function destroy($id)//删除用户
    {
        $user = User::find($id);
        $company = Input::get('');
        var_dump("123");
/*        $user = User::find($id);
        $user->delete();
        return Redirect::route('manage.users');*/
    }


}
