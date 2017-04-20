<?php

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class GroupController extends BaseController {

	public function __construct()
	{
		$this->beforeFilter('user.admin');//运行类中方法之前，必须要经过user.admin过滤
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		if ('admin' != Auth::user()->username)
		{
			return Response::json(array('result'=>'failed','error_msg'=>'You do not have access to this page'));
		}
		$allgroups = Group::all() ;//提取所有的组信息
		$tempgroups = array() ;//array()创建关联数组
		foreach($allgroups as $group)
		{
			if(count(Group::getGroupUsers($group->id)) != 0)
				$group->hasUsers = true ;
			else
				$group->hasUsers = false ;
			$tempgroups[] = $group ;
		}
		return View::make('groups.index', array('nav_active' => 'groups', 'groups' => $tempgroups,'scopes'=>Group::$scopes));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
		return View::make('groups.create',array('nav_active'=>'groups'));
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()//保存新建组信息
	{
		$group_info = Input::all();
		if(array_key_exists('privileges', $group_info))
		{
			if($group_info['privileges'] === "users")
				$group_info['privileges'] = "basic|users" ;
			else
				$group_info['privileges'] = "basic" ;
		}
		else 
			$group_info['privileges'] = null ;
		$group = new Group($group_info) ;
		if($group->save(Group::$rules,Group::$errorMessages))
		{
			return Redirect::to(URL::to('admin/groups'))//返回组管理列表
			->with('success', '用户组'.$group_info['name'].'已经创建成功');
		}
		return Redirect::route('groups.create')
		->withInput()
		->withErrors($group->errors());
	}
	
	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)// 组成员管理：添加用户到组、移除组成员
	{
		//
		//user has manager rights
		$group_info = Group::find($id) ;
		if($group_info === null)
		{
			//get group info error
			return Redirect::to(URL::to('admin/groups'))
			->with('error', '组成员查看失败，获取用户组信息失败！');
		}
		else
		{
			//get users of current group
			$users = Group::getGroupUsers($id) ;
			$ntUsers = Group::getNTGroupUsers($id) ;
			//show the group info to current user
			return View::make('groups.group_users',array('users'=>$users,'ntusers' => $ntUsers,'group' => $group_info,'nav_active' => 'groups'));
		}
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//user has manager rights
		$group_info = Group::find($id) ;
		if($group_info === null)
		{
			//get group info error
			return Redirect::to(URL::to('admin/groups'))
			->with('error', '用户组信息修改失败，获取用户组信息失败！');
		}
		else
		{
			if($group_info['name'] === 'admin' || $group_info['name'] === 'ordinary')
				return Redirect::to(URL::to('admin/groups'))->with('error', '用户组信息修改失败，此用户组为内置组，不能修改！');
			//show the group info to current user
			return View::make('groups.update',array('group_info'=>$group_info,'nav_active' => 'groups','scopes'=>Group::$scopes));
		}
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)//修改用户组信息
	{
		$group_info = Group::find($id) ;
		if($group_info === null)
		{
			//get group info error
			return Redirect::to(URL::to('admin/groups'))
			->with('error', '用户组更新失败，用户组不存在！');
		}
		
		$new_group_info = Input::all();
		if(Auth::user()->group->getID() == $id)
		{
			return Redirect::to(URL::to('admin/groups'))
			->with('error', '用户组更新失败，不能修改自己所在组的权限！');
		}
		
		if(array_key_exists('privileges', $new_group_info))
		{
			$tempPriv ="" ;
			
			foreach($new_group_info['privileges'] as $privilege)
			{
				$tempPriv .= $privilege ;
				$tempPriv .="|" ;
			}
			$new_group_info['privileges'] = $tempPriv ;

// 			if($new_group_info['privileges'] === "users")
// 				$new_group_info['privileges'] = "basic|users" ;
// 			else
// 				$new_group_info['privileges'] = "basic" ;
		}
		else 
			$new_group_info['privileges'] = null ;
		$new_group_info['id'] = $id ;
		$group_update = new Group($new_group_info) ;
		
		$checkGroups = DB::table('groups')->where('id',$id)->orwhere('name',$new_group_info['name'])->get() ;
		if(count($checkGroups) == 2)
		{
			$rules = array(
					'name'     => 'required|alphaNum|unique:groups,name',
					'privileges' => 'required|notin:null'
			);
		}
		else
		{
			$rules = array(
					'privileges' => 'required|notin:null'
			);
		}
		
		$group_update->exists = true ;
		if($group_update->save($rules,Group::$errorMessages))
		{
			return Redirect::to(URL::to('admin/groups'))
			->with('success', '用户组更新成功！');
		}
		return View::make('groups.update',array('group_info'=>$group_update,'nav_active' => 'groups','errors'=>$group_update->errors()));
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
		$group_info = Group::find($id) ;
		if($group_info === null)
		{
			//get group info error
			return Redirect::to(URL::to('admin/groups'))
			->with('error', '用户组删除失败，用户组不存在！');
		}
		if(Group::getGroupUsers($id) != null)
		return Redirect::to(URL::to('admin/groups'))->with('error', '用户组删除失败，用户组非空！');
		if($group_info['name'] === 'admin' || $group_info['name'] === 'ordinary')
			return Redirect::to(URL::to('admin/groups'))->with('error', '用户组信息修改失败，此用户组为内置组，不能修改！');
		//check user rights
		DB::table('groups')->where('id',$id)->delete();
		return Redirect::to(URL::to('admin/groups'))
		->with('success', '用户组删除成功！');
	}
	
	/**
	 * remove a user from group
	 */
	public function removeGroupUser()//移除组成员
	{
		$user_id = Input::get('user_id') ;
		
		$group_id = Input::get('group_id') ;
		
		$group_info = Group::find($group_id) ;
		$user_info = User::find($user_id) ;

		if($group_info === null)
		{
			//get group info error	
			return Redirect::action('GroupController@show', array('id' => $group_info['id']))->with('error', '组成员删除失败，查找组信息失败！');
		}
		if($user_info === null)
		{
			//get user info error
			return Redirect::action('GroupController@show', array('id' => $group_info['id']))->with('error', '组成员删除失败，组成员删除失败，查找用户信息失败！');
		}
		
		if($user_id === Auth::id())
		{
			return Redirect::action('GroupController@show', array('id' => $group_info['id']))->with('error', '组成员删除失败，不能修改自己所在的组！');
		}
		//user has manager rights
		DB::update('update users set group_id = 1 where id = '.$user_id);
		return Redirect::action('GroupController@show', array('id' => $group_info['id']))->with('success', '删除组成员成功！');
	}
	
	/**
	 * add user to group
	 */
	public function addGroupUser()//添加组成员
	{
		//get user and group id
		$user_id = Input::get('user');
		
		$group_id = Input::get('group_id') ;

		//get user and group info
		$group_info = Group::find($group_id) ;
		$user_info = User::find($user_id) ;
		
		//check user and group info
		if($group_info === null)
		{
			//get group info error
			return Redirect::action('GroupController@show', array('id' => $group_info['id']))->with('error', '组成员添加失败，查找组信息失败！');
		}
		if($user_info === null)
		{
			//get user info error
			return Redirect::action('GroupController@show', array('id' => $group_info['id']))->with('error', '组成员添加失败，查找用户信息失败！');
		}
		
		if($user_id === Auth::id())
		{
			return Redirect::action('GroupController@show', array('id' => $group_info['id']))->with('error', '组成员添加失败，不能修改自己所在的组！');
		}
		
		DB::table('users')
		->where('id',$user_info['id'])
		->update(array('group_id' => $group_info['id'])) ;
 		
		return Redirect::action('GroupController@show', array('id' => $group_info['id']))->with('success', '添加成员到组成功！');;
	}
}
