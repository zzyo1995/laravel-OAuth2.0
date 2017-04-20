<?php
include 'send.php';
use Illuminate\Support\Facades\Input;
class CompanyController extends \BaseController {

	public function __construct()
    {
        $this->beforeFilter('auth', array('only' => array('create','edit','show', 'index', 'postAddUser')));//在访问create、edit、show之前必须经过auth过滤器
        $this->beforeFilter('user.admin', array('only' => array('getCheck', 'postCheck', 'update')));
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
   		$user_id = Auth::id();
      	$companies = Company::getCompaniesByState(1,$user_id);
   		return View::make('company.addUser', array('companies'=>$companies));
	}

	/**
	 * 获取可以加入的组织
	 * @return response
	 */
public function getEnabled()
{  
	if (!Session::has('name'))
	{
    	Session::put('name', '');
	}
   $user_id = Auth::id();
   $company_name = Input::get('name');
	if (!$company_name){
		//Session::put('name', $company_name);
		$company_name = Session::get('name');
	}
	//$company_name = Session::get('name');
	Session::put('name', $company_name);
   if(!isset($company_name))
   {
      $companies = Company::getCompaniesByState(1,$user_id);
   }
   else{

      $companies = Company::getCompanyByName($company_name, 1, $user_id);
   }
	//echo "dfdf is ".$company_name;
   return View::make('company.addUser', array('companies'=>$companies));
}

	/**
	 * 申请加入组织
	 */
	public function postAddUser()
	{

		$name = Input::get('name');
		$userId = Auth::user()->id;

		$company = Company::getCompanyIdByName($name);

		if($company != null) {
			$companyUserInfo = array(
				'user_id' => $userId,
				'company_id' => $company[0]->id,
			);

			//检查该用户是否已加入
			$existCmpUser = CompanyUser::getUser($userId, $company[0]->id);

			if($existCmpUser == null){//如果该用户未加入该组织，申请加入

				$companyUser = new CompanyUser($companyUserInfo);

				if($companyUser->save()){

					return Redirect::to('company/getEnabled')
						->with('success', '申请加入组织成功。');
				}else{
					return Redirect::to('company/getEnabled')
						->with('failed', '申请加入组织失败。');
				}
			} else if($existCmpUser->state == 2){

				if(CompanyUser::updateState($existCmpUser->id,0)){
					return Redirect::to('company/getEnabled')
						->with('success', '申请加入组织成功。');
				}else{
					return Redirect::to('company/getEnabled')
						->with('failed', '申请加入组织失败。');
				}

			}
			return Redirect::to('company/getEnabled')
				->with('success', '您已加入该组织或已提交申请,请耐心等待管理员审批');

		}

		return Redirect::to('company/getEnabled')
			->with('failed', '组织不存在或已被删除。');

	}

	/**
	 *查看已加入的组织
	 */
	public function myJoin() {
		$input = Input::all();
		$userId = $input('userId');
		$companyUsers = CompanyUser::myJoin();

		foreach($companyUsers as $companyUser){
			//$company = Company::find($value->user_id);
			$company = $companyUser->company;
			$companies[] = $company;
		}


	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
		return View::make('company.create');


	}

	public function delete($id)
	{

		$userId = Auth::user()->id;
		Company::deleteCompany('id', $id, $userId);
		return Redirect::to('company');


	}

	public function getChangeCompanyInfo()
	{
		$companyId = Input::get('id');
		$name = Input::get('name');
		$email = Input::get('email');
		$address = Input::get('address');
		$phone = Input::get('phone');
		return View::make('company.changeInfo', array('companyId' => $companyId, 'name' => $name, 'email' => $email, 'address' => $address, 'phone' => $phone));
	}
	
	public function postChangeCompanyInfo()
	{	
		$companyInfo = Input::all();
		$uid = Auth::user()->id;
		$subInfo = array(
			'name' => $companyInfo['name'],
			'email'    => $companyInfo['email'],
			'applier_id'    => $uid,
		);
		
		$rules = array(
		'name' => 'required|alphaNum',
		'email' => 'required|email',
		'applier_id' => 'required'
	);
		
		$validator = Validator::make($subInfo, $rules);
		if ($validator->fails()) {    //验证未通过
			return Redirect::to('changeCompanyInfo')
				->withInput()
				->withErrors($validator->errors());
		}

		if (isset($companyInfo['email']) && ($companyInfo['email'] != $companyInfo['old_email'])) {
			Company::changeInfo($companyInfo['id'], 'email', $companyInfo['email'], $uid);
		}
		if (isset($companyInfo['name']) && ($companyInfo['name'] != $companyInfo['old_name'])) {
			Company::changeInfo($companyInfo['id'], 'name', $companyInfo['name'], $uid);
		}
		if (isset($companyInfo['address']) && ($companyInfo['address'] != $companyInfo['old_address'])) {
			Company::changeInfo($companyInfo['id'], 'address', $companyInfo['address'], $uid);
		}
		if (isset($companyInfo['phone']) && ($companyInfo['phone'] != $companyInfo['old_phone'])) {
			Company::changeInfo($companyInfo['id'], 'phone', $companyInfo['phone'], $uid);
		}

		return Redirect::to('company');
	}
	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{

		$userId = Auth::user()->id;
		$company = Input::all();
		$company['applier_id'] = $userId;

//		$validator = Validator::make($company,Company::$rules,Company::$errorMessages) ;
//		if($validator->fails())
		$existCompany = Company::getCmpByName($company['name']);
		if($existCompany != null) {
			if ($existCompany->state != 2){
				return Redirect::route('company.create')
					->with('error', '组织已存在！');
			} else {
				DB::table('company')->where('name',$company['name'])->update(array("state"=> 1 , 'applier_id'=> $userId)) ;
				return Redirect::to('company')
					->with('success','组织创建成功');
			}
//			return Redirect::route('company.create')
//			            ->withInput()
//			            ->withErrors($validator->errors());
		} else {
			$c = new Company($company);
			if($c->save()){
				return Redirect::to('company')
					->with('success','组织创建成功');
			}else{
				//return Redirect::route('company.create')
							//->with('error', '组织信息保存失败,请重试！');
			$validator = Validator::make($company,Company::$rules,Company::$errorMessages) ;
			if ($validator->fails()) {
            	$warnings = $validator->messages();
            	$show_warning = $warnings->first();
            	return Redirect::route('company.create')
							->with('error', $show_warning);
        		}
			}

		}

	}

	public function getCheck(){
		if ('sysadmin' != Auth::user()->username && 'admin' != Auth::user()->username)
		{
			return Response::json(array('result'=>'failed','error_msg'=>'You do not have access to this page'));
		}
		//$company_info = Company::paginate(10);
		$company_info = Company::getAllCompanies();

		return View::make('company.check', array('allCompany' => $company_info, 'nav_active'=>'company'));
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{

		$userId = Auth::user()->id;
		$myJoin = CompanyUser::myJoin($userId);
		//var_dump($myJoin);
		foreach($myJoin as $eachJoin){

			$company = Company::find($eachJoin->company_id);
//			var_dump($company);
			$companies[] = $company;
		}

		if(!isset($companies)) {
			$companies[] = null;
		}

		return View::make('company/show', array('myJoin' => $companies));
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

		DB::table('company')->where('name',$input['name'])->update(array("state"=>$input['state'],'reason'=>$input['reason'])) ;



		$company = DB::table('company')->where('name',$input['name'])->first();


		if($input['state'] == 0){

			$existUser = CompanyUser::getUser($company->applier_id, $company->id);

			if($existUser != null){
				CompanyUser::updateState($existUser->id, 0);
			}

		}else if($input['state'] == 1){
			$useremail = DB::table('users')->where('id',$company->applier_id)->first();
			send2rabbitmq('localhost', 'secfile', '{"action":"CreateCompany","name":"'.$company->name.'","company_id":'.$company->id.',"email":"'.$company->email.'","phone":"'.$company->phone.'","address":"'.$company->address.'","applier_email":"'.$useremail->email.'"}');
			//审核通过,将申请人添加为管理员
			$companyUserArr = array(
				'user_id'=>$company->applier_id,
				'company_id'=>$company->id,
				'type'=>1,
				'state'=>1
			);

			$existUser = CompanyUser::getUser($company->applier_id, $company->id);
			if($existUser != null){
				CompanyUser::updateState($existUser->id, 1);
			} else {
				$companyUser = new CompanyUser($companyUserArr);
				$companyUser->save();
			}


		}else if($input['state'] == 2) {
			//审核不通过,申请人若存在组织用户表中,删除
			$existUser = CompanyUser::getUser($company->applier_id, $company->id);
			if($existUser != null){
				CompanyUser::updateState($existUser->id, 2);
			}
		}

		$ret = array('result'=>'success') ;

		//组织关系修改, 发送消息到队列
		$exchange = 'org';
		$routeKey = 'org.change.'.$company->id;
		$message = '{"type":0_2, "email":"", "group_id":"", "company_id":"'.$company->id.'", "message":"the relation of organization has changed"}';

		RabbitMQ::publish($exchange, $routeKey, $message);
                $company_info = Company::getAllCompanies();
              //  View::make('company.check', array('allCompany' => $company_info, 'nav_active'=>'company'));
                // return Redirect::action("CompanyController@show", array('id' => '1'))
				//->with('error', "请输入正确的项目组名称");
		return Response::json($ret);

	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
