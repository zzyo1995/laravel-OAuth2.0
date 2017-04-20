<?php
include 'send.php';
class ClientController extends BaseController
{

	public function __construct()
	{
		$this->beforeFilter('user.admin', array('only' => 'index'));
	}

	public function index()
	{
		$allClients = Client::all();//提取所有的客户端信息
		if ('sysadmin' != Auth::user()->username && 'admin' != Auth::user()->username)
		{
			return Response::json(array('result'=>'failed','error_msg'=>'You do not have access to this page'));
		}
		return View::make('clients.index', array('nav_active' => 'clients', 'clients' => $allClients));//转向客户端列表
	}
	
	public function manage()
	{
		$allClients = Client::getClientsByUid(Auth::user()->id);//user的客户端信息
		return View::make('clients.manage', array('clients' => $allClients));//转向客户端列表
	}


	public function create()//客户端注册
	{
		$scopes = Scope::all();
		$scopenames = [];
		foreach ($scopes as $scope) {
			$scopenames[] = $scope['name'];
		}

		return View::make('clients.create', ['scope_options' => $scopenames]);
	}

	public function store()
	{
		$client_type = Input::only('client_type');
		$redirect_url = Input::only('redirect_url');
		$client_info = Input::except('client_type', 'redirect_url');
		$client_info['user_id'] = Auth::user()->id;
		$client_info['name'] = $client_info['id'];
		$rules = array(
			"id" => 'required',
			'name' => 'required',
			'scope' => 'required',
			'user_id' => 'required'
		);

		$validator = Validator::make($client_info, $rules);
		if ($validator->fails()) {    //如果验证未通过，则重新加载客户端注册页面
			return Redirect::route('clients.create')
				->withInput()
				->withErrors($validator->errors());
		}

		$client_info['secret'] = str_random(16);
		$si = $client_info['scope'];
		unset($client_info['scope']);

		$c = new Client($client_info);//调用/models的Client类
		$id = $c->id;//取得客户端ID

		if ($c->save()) {
			$c = Client::find($id); // 需要重新获取对象，否则对象id为0
			$scopes = Scope::all();
			$c->scopes()->attach($scopes[$si]->id);

			if ($client_type['client_type'] == "client") {    //客户端类型：客户端
				return Redirect::to('client-manage')
					->with('success', '客户端已注册');
			} else {
				//客户端类型：web
				$clientEndpoint = new ClientEndpoint(array('client_id' => $id, 'redirect_uri' => $redirect_url['redirect_url']));
				$clientEndpoint->save();

				return Redirect::to('client-manage')
					->with('success', '客户端已注册');
			}
		}

		return Redirect::route('clients.create')
			->withInput()
			->withErrors($c->errors());
	}

	public function destroy($id)//删除已注册客户端
	{
		// Need Auth
		$c = Client::find($id);
		$c->delete();
		return Redirect::intended('client-manage');
	}

	public function jurisSecfile()//secfile的主页
	{
		$specificClients = Client::getJurisSecfileUsers('1');
		$specificNTClients = Client::getJurisSecfileUsers('0');
		return View::make('safeadmin.secfile', array('nav_active' => 'secfile', 'clients' => $specificClients, 'ntclients' => $specificNTClients));//转向客户端列表
	}

	public function jurisGitlab()//gitlab的主页
	{
		$specificClients = Client::getJurisGitlabUsers('1');
		$specificNTClients = Client::getJurisGitlabUsers('0');
		return View::make('safeadmin.gitlab', array('nav_active' => 'gitlab', 'clients' => $specificClients, 'ntclients' => $specificNTClients));//转向客户端列表
	}

	public function jurisRiochat()//riochat的主页
	{
		$specificClients = Client::getJurisRiochatUsers('1');
		$specificNTClients = Client::getJurisRiochatUsers('0');
		return View::make('safeadmin.riochat', array('nav_active' => 'riochat', 'clients' => $specificClients, 'ntclients' => $specificNTClients));//转向客户端列表
	}

	public function changeJuris($id, $cname)//提交修改
	{

		$client_info = Input::all();
		if($client_info === null)
		{
			switch($cname)
			{
				case "secfile":
					return Redirect::action('ClientController@jurisSecfile', with('error', '获取用户信息失败！'));
					break;
				case "gitlab":
					return Redirect::action('ClientController@jurisGitlab', with('error', '获取用户信息失败！'));
					break;
				case "riochat":
					return Redirect::action('ClientController@jurisRiochat', with('error', '获取用户信息失败！'));
					break;
				default:
					return Redirect::action('AdminController@safehome', with('error', '操作失败！'));
			}
		}

		$user_info = DB::table('users')->where('id',$id)->first();

		switch($cname)
		{
			case "secfile":
				DB::table('user_jurisdiction')
					->where('user_id', $id)
					->update(array('miji' => $client_info['miji'], 'userstatus' => $client_info['userstatus'], 'addadmin' => $client_info['addadmin']));

				send2rabbitmq('localhost', 'secfile', '{"action":"UpdateSecfileJurisdiction","name":"'.$user_info->username.'","email":"'.$user_info->email.'","miji":"'.$client_info['miji'].'","userstatus":"'.$client_info['userstatus'].'","addadmin":"'.$client_info['addadmin'].'"}');

				return Redirect::action('ClientController@jurisSecfile', with('success', '修改成功！'));
				break;
			case "gitlab":
				DB::table('user_jurisdiction')
					->where('user_id', $id)
					->update(array('miji' => $client_info['miji'], 'usersjuris' => $client_info['usersjuris'], 'codejuris' => $client_info['codejuris'], 'users_jira_juris' => $client_info['users_jira_juris']));

				send2rabbitmq('localhost', 'gitlab', '{"action":"UpdateGitlabJurisdiction","name":"'.$user_info->username.'","email":'.$user_info->email.',"miji":"'.$client_info['miji'].'","usersjuris":"'.$client_info['usersjuris'].'","codejuris":"'.$client_info['codejuris'].'","users_jira_juris":"'.$client_info['users_jira_juris'].'"}');

				return Redirect::action('ClientController@jurisGitlab', with('success', '修改成功！'));
				break;
			case "riochat":
				DB::table('user_jurisdiction')
					->where('user_id', $id)
					->update(array('user_miji' => $client_info['user_miji'] ));

				send2rabbitmq('localhost', 'riochat', '{"action":"UpdateRiochatJurisdiction","name":"'.$user_info->username.'","email":"'.$user_info->email.'","user_miji":"'.$client_info['user_miji'].'"}');

				return Redirect::action('ClientController@jurisRiochat', with('success', '修改成功！'));
				break;
			default:
				return Redirect::action('AdminController@safehome', with('error', '操作失败！'));
		}

	}

	public function addJurisUser($cname)
	{
		$id = Input::get('user_id');

		if($cname)
		{
			switch($cname)
			{
				case "secfile":
					$curMax = DB::table('user_jurisdiction')->max('secfile_type');
					DB::table('user_jurisdiction')
						->where('user_id',$id)
						->update(array('secfile_type' => $curMax+1)) ;
					return Redirect::action('ClientController@jurisSecfile', with('success', '添加成功！'));
					break;
				case "gitlab":
					$curMax = DB::table('user_jurisdiction')->max('gitlab_type');
					DB::table('user_jurisdiction')
						->where('user_id',$id)
						->update(array('gitlab_type' => $curMax+1)) ;
					return Redirect::action('ClientController@jurisGitlab', with('success', '添加成功！'));
					break;
				case "riochat":
					$curMax = DB::table('user_jurisdiction')->max('riochat_type');
					DB::table('user_jurisdiction')
						->where('user_id',$id)
						->update(array('riochat_type' => $curMax+1)) ;
					return Redirect::action('ClientController@jurisRiochat', with('success', '添加成功！'));
					break;
				default:
					return Redirect::action('AdminController@safehome', with('error', '操作失败！'));
			}
		}
	}

	public function removeJurisUser($id, $cname)
	{

		if($id === null)
		{	switch($cname)
			{
			case "secfile":
				return Redirect::action('ClientController@jurisSecfile', with('error', '获取用户信息失败！'));
				break;
			case "gitlab":
				return Redirect::action('ClientController@jurisGitlab', with('error', '获取用户信息失败！'));
				break;
			case "riochat":
				return Redirect::action('ClientController@jurisRiochat', with('error', '获取用户信息失败！'));
				break;
			default:
				return Redirect::action('AdminController@safehome', with('error', '操作失败！'));
			}
		}

		switch($cname)
		{
			case "secfile":
				DB::table('user_jurisdiction')
					->where('user_id',$id)
					->update(array('secfile_type' => '0')) ;
				return Redirect::action('ClientController@jurisSecfile', with('success', '移除成功！'));
				break;
			case "gitlab":
				DB::table('user_jurisdiction')
					->where('user_id',$id)
					->update(array('gitlab_type' => '0')) ;
				return Redirect::action('ClientController@jurisGitlab', with('success', '移除成功！'));
				break;
			case "riochat":
				DB::table('user_jurisdiction')
					->where('user_id',$id)
					->update(array('riochat_type' => '0')) ;
				return Redirect::action('ClientController@jurisRiochat', with('success', '移除成功！'));
				break;
			default:
				return Redirect::action('AdminController@safehome', with('error', '操作失败！'));
		}
	}
}
