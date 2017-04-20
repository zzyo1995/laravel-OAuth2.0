<?php
include 'send.php';

class ProjectGroupController extends \BaseController
{

    public function __construct()
    {
        $this->beforeFilter('user.manage');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

        $userId = Auth::user()->id;
        $companyUsers = CompanyUser::getCompanyUserByUserId($userId);

        foreach ($companyUsers as $eachCompanyUser) {
            $company = Company::find($eachCompanyUser->company_id);
            $companies[] = $company;
        }

        if (!isset($companies)) {
            $companies[] = null;
        }

        return View::make('department.index', array('nav_active' => 'projectGroup', 'companies' => $companies));

    }


    public function showGroups()
    {
        //
        $companyId = Input::get('companyId');
        $companyName = Input::get('companyName');
        $allNoOwnerGroups = DB::table("project_group")->where('super_id', 0)->where("company_id", $companyId)->get();
        $projectGroups = ProjectGroup::listGroups($companyId, null);
        return View::make('projects.index', array(
                'projectGroups' => $projectGroups,
                'companyId' => $companyId,
                'allNoOwnerGroups' => $allNoOwnerGroups,
                'companyName' => $companyName,
                'nav_active' => 'projectGroup'
            ));
    }

    public function getAddProjectGroup()
    {
        $companyId = Input::get('companyId');
        $companyName = Input::get('companyName');
        //print $departmentId;
        return View::make('projects.create', array(
                'nav_active' => 'projectGroup',
                'companyId' => $companyId,
                'companyName' => $companyName
            ));
    }

    public function existSpace($string)
    {
        for ($i = 0; $i < strlen($string); $i++) {
            $char = substr($string, $i, 1);
            if ($char == ' ') {
                return 1;
            }
        }
        return 0;

    }

    // 修改组信息
    public function getChProjectGroup()
    {
        $companyId = Input::get('companyId');
        $companyName = Input::get('companyName');
        $projectGroupId = Input::get('projectGroupId');
        //print $departmentId;
        return View::make('projects.change', array(
                'nav_active' => 'projectGroup',
                'projectGroupId' => $projectGroupId,
                'companyId' => $companyId,
                'companyName' => $companyName
            ));
    }

    public function postChProjectGroup()
    {
        $companyId = Input::get('companyId');
        $projectGroupId = Input::get('projectGroupId');
        $projectInfo = DB::table('project_group')->where('id', $projectGroupId)->first();
        $companyName = Input::get('companyName');
        $projectGroupName = Input::get('name');
        if ($this->existSpace($projectGroupName)) {
            return Redirect::action("ProjectGroupController@getChProjectGroup", array(
                    'nav_active' => 'projectGroup',
                    'companyId' => $companyId,
                    'companyName' => $companyName
                ))->with('error', "请输入正确的项目组名称");
        }
        $projectGroupEnName = Input::get('enname');
        if ($projectGroupEnName != null and !ctype_alnum($projectGroupEnName)) {
            return Redirect::action("ProjectGroupController@getChProjectGroup", array(
                    'nav_active' => 'projectGroup',
                    'companyId' => $companyId,
                    'companyName' => $companyName
                ))->with('error', "请输入正确的项目组英文名称");
            //  return View::make('projects.create', array('nav_active' => 'projectGroup', 'companyId' => $companyId, 'companyName' => $companyName,'error'=> 1));
        }
        $leaf = Input::get('leaf');
        if ($leaf != null and $leaf != '0' and $leaf != '1') {
            return Redirect::action("ProjectGroupController@getChProjectGroup", array(
                    'nav_active' => 'projectGroup',
                    'companyId' => $companyId,
                    'companyName' => $companyName
                ))->with('error', "输入的叶子组修改信心不正确，请重新输入！");
        }
        $projectGroupInfo = array(
            'company_id' => $companyId,
            'name' => $projectGroupName,
            'enname' => $projectGroupEnName,
        );

        $existGroup = ProjectGroup::checkNameUnique($companyId, $projectGroupName);
        $existEnGroup = ProjectGroup::checkEnNameUnique($companyId, $projectGroupEnName);
        if ($existGroup != null) {
            return Redirect::action("ProjectGroupController@getChProjectGroup", array(
                    'nav_active' => 'projectGroup',
                    'companyId' => $companyId,
                    'companyName' => $companyName
                ))->with('error', "项目组名 '".$projectGroupName."' 已存在!");
        }
        if ($projectGroupEnName != null and $existEnGroup != null) {
            return Redirect::action("ProjectGroupController@getChProjectGroup", array(
                    'nav_active' => 'projectGroup',
                    'companyId' => $companyId,
                    'companyName' => $companyName
                ))->with('error', "项目组英文名 '".$projectGroupEnName."' 已存在!");
        }
        if ($projectGroupName != null) {
            DB::table('project_group')->where('id', $projectGroupId)->update(array('name' => $projectGroupName));
            $msName = array(
                'action' => 'ChangeProjectGroupName',
                'project_group_id' => $projectGroupId,
                'project_group_old_name' => $projectInfo->name,
                'project_group_new_name' => $projectGroupName,
                'company_name' => $companyName,
            );

            $msjsonName = json_encode($msName, JSON_UNESCAPED_UNICODE);
            send2rabbitmq('localhost', 'secfile', $msjsonName);
        }
        if ($projectGroupEnName != null) {
            DB::table('project_group')->where('id', $projectGroupId)->update(array('enname' => $projectGroupEnName));
            $msEnName = array(
                'action' => 'ChangeProjectGroupEnName',
                'project_group_id' => $projectGroupId,
                'project_group_old_enname' => $projectInfo->enname,
                'project_group_new_enname' => $projectGroupEnName,
                'company_name' => $companyName,
            );

            $msjsonEnName = json_encode($msEnName, JSON_UNESCAPED_UNICODE);
            send2rabbitmq('localhost', 'secfile', $msjsonEnName);
        }
        if ($leaf != null) {
            DB::table('project_group')->where('id', $projectGroupId)->update(array('leaf' => $leaf));
            $msLeaf = array(
                'action' => 'ChangeProjectGroupLeaf',
                'project_group_id' => $projectGroupId,
                'project_group_old_leaf' => $projectInfo->leaf,
                'project_group_new_leaf' => $leaf,
                'company_name' => $companyName,
            );

            $msjsonLeaf = json_encode($msLeaf, JSON_UNESCAPED_UNICODE);
            send2rabbitmq('localhost', 'secfile', $msjsonLeaf);
        }
        return Redirect::action('ProjectGroupController@showGroups', array(
                'nav_active' => 'projectGroup',
                'companyId' => $companyId,
                'companyName' => $companyName
            ))->with('success', '修改成功！');


    }
    // public function existeillegal($string){

    //          if($string =='/^[0-9a-zA-Z_\x{4e00}-\x{9fa5}]+$/u'){
    // return ;
    //        }

    //return 1;

    //}


    public function postAddProjectGroup()
    {
        $companyId = Input::get('companyId');
        $companyName = Input::get('companyName');
        $projectGroupName = Input::get('name');
        if ($this->existSpace($projectGroupName) or $projectGroupName == null) {
            return Redirect::action("ProjectGroupController@getAddProjectGroup", array(
                    'nav_active' => 'projectGroup',
                    'companyId' => $companyId,
                    'companyName' => $companyName
                ))->with('error', "请输入项目组名称");
        }


        //      if($this->existeillegal($projectGroupName) or $projectGroupName==null){
        //    return Redirect::action("ProjectGroupController@getAddProjectGroup", array('nav_active' => 'projectGroup', 'companyId' => $companyId, 'companyName' => $companyName))
        //		->with('error', "！请输入正确的项目组名称");
        //}


        $projectGroupEnName = Input::get('enname');
        if (!ctype_alnum($projectGroupEnName)) {
            return Redirect::action("ProjectGroupController@getAddProjectGroup", array(
                    'nav_active' => 'projectGroup',
                    'companyId' => $companyId,
                    'companyName' => $companyName
                ))->with('error', "请输入正确的项目组英文名称");
            //  return View::make('projects.create', array('nav_active' => 'projectGroup', 'companyId' => $companyId, 'companyName' => $companyName,'error'=> 1));
        }
        $projectGroupInfo = array(
            'company_id' => $companyId,
            'name' => $projectGroupName,
            'enname' => $projectGroupEnName,
        );

        $existGroup = ProjectGroup::queryByCondition($companyId, null, $projectGroupName);
        $existEnGroup = ProjectGroup::queryByEnCondition($companyId, null, $projectGroupEnName);
        if ($existGroup != null) {
            return Redirect::action("ProjectGroupController@getAddProjectGroup", array(
                    'nav_active' => 'projectGroup',
                    'companyId' => $companyId,
                    'companyName' => $companyName
                ))->with('error', "项目组 '".$projectGroupName."' 已存在!");
        }
        if ($existEnGroup != null) {
            return Redirect::action("ProjectGroupController@getAddProjectGroup", array(
                    'nav_active' => 'projectGroup',
                    'companyId' => $companyId,
                    'companyName' => $companyName
                ))->with('error', "项目组 '".$projectGroupEnName."' 已存在!");
        }

        $projectGroup = new ProjectGroup($projectGroupInfo);
        if ($projectGroup->save(ProjectGroup::$rules)) {

            $user = User::find(Auth::user()->id);

            //组织关系修改, 发送消息到队列
            $exchange = 'org';
            $routeKey = 'org.change.'.$companyId;
            $message = '{type:1_0, "email":"'.
                       strtolower($user->email).
                       '", "group_id":"'.
                       $projectGroup->id.
                       '", "company_id":"'.
                       $companyId.
                       '", "message":"add a new project group"}';

            RabbitMQ::publish($exchange, $routeKey, $message);

            $sid = $projectGroup->super_id;
            if ($sid == null) {
                $sid = -1;
            }

            $ms = array(
                'action' => 'CreateProjectGroup',
                'email' => $user->email,
                'super_id' => $sid,
                'project_group_id' => $projectGroup->id,
                'company_id' => $companyId,
                'company_name' => $companyName,
                'project_group_name' => $projectGroupName,
                'project_group_Enname' => $projectGroupEnName,
            );

            $msjson = json_encode($ms, JSON_UNESCAPED_UNICODE);
            send2rabbitmq('localhost', 'secfile', $msjson);
            return Redirect::action('ProjectGroupController@showGroups', array(
                    'nav_active' => 'projectGroup',
                    'companyId' => $companyId,
                    'companyName' => $companyName
                ))->with('success', '创建项目组成功！');
        }


    }

    /**
     * 子项目组列表
     * @return
     */
    public function sonGroups()
    {
        $companyId = Input::get('companyId');
        $companyName = Input::get('companyName');
        $superId = Input::get('superId');
        $projectGroupName = Input::get('projectGroup_name');
        $projectGroups = ProjectGroup::listGroups($companyId, $superId);
        $allNoOwnerGroups = ProjectGroup::getAllNoOwnerGroups($projectGroupName, $superId, $companyId);
        return View::make('projects.sonIndex', array(
                'projectGroups' => $projectGroups,
                'companyId' => $companyId,
                'companyName' => $companyName,
                'projectGroupName' => $projectGroupName,
                'superId' => $superId,
                'allNoOwnerGroups' => $allNoOwnerGroups,
                'nav_active' => 'projectGroup'
            ));
    }

    /**
     * 跳转到添加子项目组页面
     * @return mixed
     */
    public function getAddSonProjectGroup()
    {
        $companyId = Input::get('companyId');
        $companyName = Input::get('companyName');
        $superId = Input::get('superId');
        $projectGroupName = Input::get('projectGroup_name');


        //var_dump($companyId);
        //var_dump($superId);
        //print $departmentId;
        return View::make('projects.createSon', array(
                'nav_active' => 'projectGroup',
                'companyId' => $companyId,
                'projectGroupName' => $projectGroupName,
                'companyName' => $companyName,
                'superId' => $superId
            ));
    }


    public function postAddSonProjectGroup()
    {
        $companyId = Input::get('companyId');
        $companyName = Input::get('companyName');
        $superId = Input::get('superId');
        $curName = DB::table('project_group')->where('id', $superId)->pluck('name');
        $projectGroupName = Input::get('name');
        $projectGroupEnName = Input::get('enname');
        $projectGroupInfo = array(
            'name' => $projectGroupName,
            'enname' => $projectGroupEnName,
            'company_id' => $companyId,
            'super_id' => $superId,
        );

        $existGroup = ProjectGroup::queryByCondition($companyId, $superId, $projectGroupName);

        if ($existGroup != null) {
            return Redirect::action("ProjectGroupController@getAddSonProjectGroup", array(
                    'nav_active' => 'projectGroup',
                    'companyId' => $companyId,
                    'superId' => $superId
                ))->with('error', "项目组 '".$projectGroupName."' 已存在!");
        }


        if ($this->existSpace($projectGroupName) or $projectGroupName == null) {
            return Redirect::action('ProjectGroupController@getAddSonProjectGroup', array(
                    'nav_active' => 'projectGroup',
                    'companyId' => $companyId,
                    'superId' => $superId
                ))->with('error', "请输入正确的子项目组名称");
        }

        if (!ctype_alnum($projectGroupEnName)) {
            return Redirect::action('ProjectGroupController@getAddSonProjectGroup', array(
                    'nav_active' => 'projectGroup',
                    'companyId' => $companyId,
                    'superId' => $superId
                ))->with('error', "请输入正确的子项目组英文名称");
        }


        $projectGroup = new ProjectGroup($projectGroupInfo);

        if ($projectGroup->save(ProjectGroup::$rule123)) {
            //var_dump($projectGroup);
            $user = User::find(Auth::user()->id);

            //组织关系修改, 发送消息到队列
            $exchange = 'org';
            $routeKey = 'org.change.'.$companyId;
            $message = '{"type":1_0, "email":"'.
                       strtolower($user->email).
                       '", "group_id":"'.
                       $projectGroup->id.
                       '", "company_id":"'.
                       $companyId.
                       '", "message":"add a son project group"}';

            RabbitMQ::publish($exchange, $routeKey, $message);

            $sid = $projectGroup->super_id;
            $ms = array(
                'action' => 'CreateProjectGroup',
                'email' => $user->email,
                'super_id' => $sid,
                'project_group_id' => $projectGroup->id,
                'company_id' => $companyId,
                'company_name' => $companyName,
                'project_group_name' => $projectGroupName,
                'project_group_Enname' => $projectGroupEnName,
            );

            $msjson = json_encode($ms, JSON_UNESCAPED_UNICODE);
            send2rabbitmq('localhost', 'secfile', $msjson);
            return Redirect::action('ProjectGroupController@sonGroups', array(
                    'nav_active' => 'projectGroup',
                    'companyId' => $companyId,
                    'projectGroup_name' => $curName,
                    'superId' => $superId
                ))->with('success', '创建子项目组成功！');
        }

    }

    public function projectMember()
    {
        $projectGroupId = Input::get('projectGroup_id');
        $projectGroupName = Input::get('projectGroup_name');

		$projectRoles = ProjectRole::getAllRoles();
        //print_r($projectGroupId);
        $allMember = ProjectGroupMember::listMembers($projectGroupId);
        foreach ($allMember as $member) {
            $user = User::find($member->user_id);
            $uc = DB::table('oauth_roles')->where('name', $user->user_category)->pluck('description');
            $userInfo[] = array(
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
                'user_category' => $uc,
                'phone' => $user->phone,
                'type' => $member->type,
            );
        }
        if (!isset($userInfo)) {
            $userInfo[] = array();
        }

        //print_r($userInfo[0]['username']);
        //print_r($userInfo);

        return View::make('projects.allMember', array(
                'nav_active' => 'projectGroup',
                'userInfo' => $userInfo,
                'projectGroupName' => $projectGroupName,
                'projectRoles' => $projectRoles,
                'projectGroupId' => $projectGroupId
            ));

    }

    public function changeProjectRole()
    {
        $userId = Input::get('userId');
        $projectGroupId = Input::get('projectGroup_id');
        $projectGroupName = Input::get('projectGroup_name');
		$type = Input::get('type');
        if (ProjectGroupMember::updateType($projectGroupId, $userId, $type)) {

            $user = User::find($userId);
            $projectGroup = ProjectGroup::find($projectGroupId);
			// 兼容以前的消息SetLeader和CancelLeader
			if ($type == 1) {
            send2rabbitmq('localhost', 'secfile', '{"action":"SetLeader","company_id":'.
                                                  $projectGroup->company_id.
                                                  ',"email":"'.
                                                  strtolower($user->email).
                                                  '","group_id":'.
                                                  $projectGroupId.
                                                  ', "projectGroupName":"'.
                                                  $projectGroupName.
                                                  '", "projectGroupEnName":"'.
                                                  $projectGroup->enname.
                                                  '"}');
			
			} else {
            send2rabbitmq('localhost', 'secfile', '{"action":"CancelLeader","company_id":'.
                                                  $projectGroup->company_id.
                                                  ',"email":"'.
                                                  strtolower($user->email).
                                                  '","group_id":'.
                                                  $projectGroupId.
                                                  ', "projectGroupName":"'.
                                                  $projectGroupName.
                                                  '", "projectGroupEnName":"'.
                                                  $projectGroup->enname.
                                                  '"}');
			
			}
            //组织关系修改, 发送消息到队列
            $exchange = 'org';
            $routeKey = 'org.change.'.$projectGroup->company_id;
            $message = '{"type":2_2, "email":"'.
                       strtolower($user->email).
                       '", "group_id":"'.
                       $projectGroupId.
                       '", "company_id":"'.
                       $projectGroup->company_id.
                       '", "message":"the member set to be a leader"}';
            send2rabbitmq('localhost', 'secfile', '{"action":"ChangeProjectRole","company_id":'.
                                                  $projectGroup->company_id.
                                                  ',"email":"'.
                                                  strtolower($user->email).
                                                  '","type":'.
                                                  $type.
                                                  '","group_id":'.
                                                  $projectGroupId.
                                                  ', "projectGroupName":"'.
                                                  $projectGroupName.
                                                  '", "projectGroupEnName":"'.
                                                  $projectGroup->enname.
                                                  '"}');
            RabbitMQ::publish($exchange, $routeKey, $message);

        }

        return Redirect::action('ProjectGroupController@projectMember',
            array('projectGroup_id' => $projectGroupId, 'projectGroup_name' => $projectGroupName));

    }

    public function cancelLeader()
    {
        $userId = Input::get('userId');
        $projectGroupId = Input::get('projectGroup_id');
        $projectGroupName = Input::get('projectGroup_name');

        if (ProjectGroupMember::updateType($projectGroupId, $userId, 0)) {

            $user = User::find($userId);
            $projectGroup = ProjectGroup::find($projectGroupId);

            //组织关系修改, 发送消息到队列
            $exchange = 'org';
            $routeKey = 'org.change.'.$projectGroup->company_id;
            $message = '{"type":2_2, "email":"'.
                       strtolower($user->email).
                       '", "group_id":"'.
                       $projectGroupId.
                       '", "company_id":"'.
                       $projectGroup->company_id.
                       '", "message":"the member cancel the leader"}';
            send2rabbitmq('localhost', 'secfile', '{"action":"CancelLeader","company_id":'.
                                                  $projectGroup->company_id.
                                                  ',"email":"'.
                                                  strtolower($user->email).
                                                  '","group_id":'.
                                                  $projectGroupId.
                                                  ', "projectGroupName":"'.
                                                  $projectGroupName.
                                                  '", "projectGroupEnName":"'.
                                                  $projectGroup->enname.
                                                  '"}');
            RabbitMQ::publish($exchange, $routeKey, $message);

        }

        return Redirect::action('ProjectGroupController@projectMember',
            array('projectGroup_id' => $projectGroupId, 'projectGroup_name' => $projectGroupName));
    }

    public function searchUser()
    {
    	$projectGroupId = Input::get('id');
        $projectGroup = ProjectGroup::find($projectGroupId);
    	$name = Input::get('name');
		$companyId = $projectGroup->company_id;
		$companyUsers = DB::table('company_users')
				->where('company_id', $companyId)->where('state', 1)->get();
		foreach ($companyUsers as $companyUser) {
			$tp = User::find($companyUser->user_id);
			if ($tp->username == $name) {
				$allUser[] = $tp;
				$companyUsers = DB::table('company_users')
					->where('company_id', $companyId)->where('state', 1)->where('user_id', $tp->id)->paginate(16);
				break;
			}

		}
        if (!isset($allUser)) {
            $allUser[] = array();
            $companyUsers = array();
        }

        //var_dump($companyUsers);
        return View::make('projects.addMember', array(
                'nav_active' => 'projectGroup',
                'allUser' => $allUser,
                'companyUsers' => $companyUsers,
                'projectGroup_id' => $projectGroupId,
                'projectGroupName' => $projectGroup->name
            ));

    }
    public function getAddProjectMember($id)
    {
        $projectGroupId = $id;
        $projectGroup = ProjectGroup::find($projectGroupId);
/*
        $company = $projectGroup->company;

        $companyUsers = $company->companyUser;

        foreach ($companyUsers as $companyUser) {
            if ($companyUser->state == 1) {
                $member = ProjectGroupMember::queryByUid($projectGroupId, $companyUser->user_id);
                if ($member == null) {
                    $tempuser = User::find($companyUser->user_id);
                    if ($tempuser == null) {
                        dd($companyUser->user_id);
                    }
                    $users[] = User::find($companyUser->user_id);
                }
            }
        }
*/
		$companyId = $projectGroup->company_id;
		$companyUsers = DB::table('company_users')
				->where('company_id', $companyId)->where('state', 1)->paginate(16);
		foreach ($companyUsers as $companyUser) {
			$tp = User::find($companyUser->user_id);
			$allUser[] = $tp;

		}
        if (!isset($allUser)) {
            $allUser[] = array();
        }

        //var_dump($companyUsers);
        return View::make('projects.addMember', array(
                'nav_active' => 'projectGroup',
                'allUser' => $allUser,
                'companyUsers' => $companyUsers,
                'projectGroup_id' => $projectGroupId,
                'projectGroupName' => $projectGroup->name
            ));

    }

    public function postAddProjectMember()
    {
        $projectGroupId = Input::get("project_group_id");
        $projectGroupName = Input::get("project_group_name");
        $uidStr = Input::get("uid");
        //$results = array();
        //$groupResults = array();

        if ($uidStr != "") {
            $arr = explode(",", $uidStr);
            foreach ($arr as $uid) {
                $results = array();
                $groupResults = array();
                $member = ProjectGroupMember::queryByUid($projectGroupId, $uid);

                if ($member == null) {
                    $memberInfo = array(
                        "project_group_id" => $projectGroupId,
                        "user_id" => $uid
                    );
                    $projectGroupMember = new ProjectGroupMember($memberInfo);

                    if ($projectGroupMember->save(ProjectGroupMember::$rules)) {

                        $user = User::find($uid);
                        $projectGroup = ProjectGroup::find($projectGroupId);

                        $rgroup[] = $projectGroup;
                        ProjectGroupMember::getProjectGroupsByUser($rgroup, $results);
                        $results[] = $projectGroup;
                        $companyapply = DB::table('company')->where('id', $projectGroup->company_id)->first();

                        foreach ($results as $result) {
                            $groupResults[] = array(
                                'project_group_id' => $result->id,
                                'project_group_name' => $result->name,
                                'project_group_enname' => $result->enname,
                                'project_group_leaf' => $result->leaf,
                            );
                        }

                        $ms = array(
                            'action' => 'DestributeMember',
                            'company_id' => $projectGroup->company_id,
                            'company_name' => $companyapply->name,
                            'employee_email' => $user->email,
                            'project_groups' => $groupResults,
                        );
                        $msjson = json_encode($ms, JSON_UNESCAPED_UNICODE);

                        //组织关系修改, 发送消息到队列
                        $exchange = 'org';
                        $routeKey = 'org.change.'.$projectGroup->company_id;
                        $message = '{"type":2_0, "email":"'.
                                   strtolower($user->email).
                                   '", "group_id":"'.
                                   $projectGroupId.
                                   '", "company_id":"'.
                                   $projectGroup->company_id.
                                   '", "message":"the project group has added new member"}';

                        send2rabbitmq('localhost', 'secfile', $msjson);
                        RabbitMQ::publish($exchange, $routeKey, $message);

                    }
                }
                unset($results);
                unset($groupResults);
            }
        }

        return Redirect::action("ProjectGroupController@projectMember",
            array("projectGroup_id" => $projectGroupId, "projectGroup_name" => $projectGroupName));

    }

    public function deleteProjectMember()
    {
        $projectGroupId = Input::get("projectGroup_id");
        $userId = Input::get("userId");

        $member = ProjectGroupMember::queryByUid($projectGroupId, $userId);

        if (ProjectGroupMember::deleteMemberById($member->id)) {
            $projectGroup = ProjectGroup::find($projectGroupId);

            $user = User::find($userId);

            //组织关系修改, 发送消息到队列
            $exchange = 'org';
            $routeKey = 'org.change.'.$projectGroup->company_id;
            $message = '{"type":2_1, "email":"'.
                       strtolower($user->email).
                       '", "group_id":"'.
                       $projectGroupId.
                       '", "company_id":"'.
                       $projectGroup->company_id.
                       '", "message":"the project group has added new member"}';

            RabbitMQ::publish($exchange, $routeKey, $message);
            $companyapply = DB::table('company')->where('id', $projectGroup->company_id)->first();
            send2rabbitmq('localhost', 'secfile', '{"action":"DeleteMember","email":"'.
                                                  $user->email.
                                                  '","company_name":"'.
                                                  $companyapply->name.
                                                  '","project_group_name":"'.
                                                  $projectGroup->name.
                                                  '","project_group_enname":"'.
                                                  $projectGroup->enname.
                                                  '","company_id":'.
                                                  $projectGroup->company_id.
                                                  ',"project_group_id":'.
                                                  $projectGroupId.
                                                  '}');

            return Redirect::action("ProjectGroupController@projectMember", array(
                    "projectGroup_id" => $projectGroupId,
                    "projectGroup_name" => $projectGroup->name
                ))->with("success", "删除成功");
        }
        $projectGroup = ProjectGroup::find($projectGroupId);
        return Redirect::action("ProjectGroupController@projectMember",
            array("projectGroup_id" => $projectGroupId, "projectGroup_name" => $projectGroup->name))
            ->with("error", "删除失败");

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
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function Sondestroy($id)
    {
        $projectId = $id;
        $companyId = Input::get('companyId');
        $projectGroup_name = Input::get('projectGroup_name');
        $projectinfo = DB::table('project_group')->where('id', $projectId)->first();
        $curName = DB::table('project_group')->where('id', $projectinfo->super_id)->pluck('name');
        $groupState = ProjectGroup::deleteGroupById($projectId);
        //ProjectGroupMember::deleteMember($projectId);
        //var_dump($projectinfo);
        if ($groupState) {

            $user = User::find(Auth::user()->id);

            //组织关系修改, 发送消息到队列
            $exchange = 'org';
            $routeKey = 'org.change.'.$companyId;
            $message = '{"type":1_1, "email":"'.
                       strtolower($user->email).
                       '", "group_id":"'.
                       $projectId.
                       '", "company_id":"'.
                       $companyId.
                       '", "message":"the project group has been deleted"}';

            RabbitMQ::publish($exchange, $routeKey, $message);
            $ms = array(
                'action' => 'DestroySonProjectGroup',
                'email' => $user->email,
                'project_group_id' => $projectId,
		        'super_id' => $projectinfo->super_id,
                'company_id' => $companyId,
            );

            $msjson = json_encode($ms, JSON_UNESCAPED_UNICODE);
            send2rabbitmq('localhost', 'secfile', $msjson);

            return Redirect::action('ProjectGroupController@sonGroups', array(
                    'superId' => $projectinfo->super_id,
                    'projectGroup_name' => $curName,
                    'companyId' => $companyId
                ))->with('success', "删除成功!");
        }

        return Redirect::action('ProjectGroupController@sonGroups', array(
                'superId' => $projectinfo->super_id,
                'projectGroup_name' => $curName,
                'companyId' => $companyId
            ))->with('error', "删除失败!");

    }

    public function destroy($id)
    {
        $projectId = $id;
        $companyId = Input::get('companyId');
        $companyName = Input::get('companyName');
        $projectinfo = DB::table('project_group')->where('id', $projectId)->first();
        $groupState = ProjectGroup::deleteGroupById($projectId);
        //ProjectGroupMember::deleteMember($projectId);
        //var_dump($projectinfo);
        if ($groupState) {

            $user = User::find(Auth::user()->id);

            //组织关系修改, 发送消息到队列
            $exchange = 'org';
            $routeKey = 'org.change.'.$companyId;
            $message = '{"type":1_1, "email":"'.
                       strtolower($user->email).
                       '", "group_id":"'.
                       $projectId.
                       '", "company_id":"'.
                       $companyId.
                       '", "message":"the project group has been deleted"}';

            RabbitMQ::publish($exchange, $routeKey, $message);
            $ms = array(
                'action' => 'DestroyProjectGroup',
                'email' => $user->email,
                'project_group_id' => $projectId,
                'company_id' => $companyId,
            );

            $msjson = json_encode($ms, JSON_UNESCAPED_UNICODE);
            send2rabbitmq('localhost', 'secfile', $msjson);

            return Redirect::action('ProjectGroupController@showGroups',
                array('companyId' => $companyId, 'companyName' => $companyName))->with('success', "删除成功!");
        }

        return Redirect::action('ProjectGroupController@showGroups',
            array('companyId' => $companyId, 'companyName' => $companyName))->with('error', "删除失败!");

    }

    /**
     * Add a son group by name.
     *
     */
    public function AddSonProjectGroupByName()
    {
        $companyId = Input::get('companyId');
        $companyInfo = DB::table('company')->where('id', $companyId)->first();
        $superId = Input::get('superId');
        $pg_id = Input::get('pg_id');
        $sname = Input::get('projectGroupName');
        $sid = DB::table('project_group')->where('name', $sname)->pluck('id');
        DB::table('project_group')->where('id', $pg_id)->update(['super_id' => $sid]);
        $projectinfo = DB::table('project_group')->where('id', $pg_id)->first();
        $user = User::find(Auth::user()->id);
        if ($sid == null) {
            $sid = -1;
        }        
	    $ms = array(
		    'action' => 'AddSonProjectGroup',
            'email' => $user->email,
            'super_id' => $sid,
            'project_group_id' => $pg_id,
            'company_id' => $companyId,
            'company_name' => $companyInfo->name,
            'project_group_name' => $projectinfo->name,
            'project_group_Enname' => $projectinfo->enname,
        );

        $msjson = json_encode($ms, JSON_UNESCAPED_UNICODE);
        send2rabbitmq('localhost', 'secfile', $msjson);

        return Redirect::action('ProjectGroupController@sonGroups',
            array('superId' => $superId, 'projectGroup_name' => $sname, 'companyId' => $companyId))
            ->with('success', '添加项目组成功！');
    }

    /**
     * Add a group by name.
     *
     */
    public function AddProjectGroupByName()
    {
        $companyId = Input::get('companyId');
        $companyName = Input::get('companyName');
        $pid = Input::get('pid');
        DB::table('project_group')->where('id', $pid)->update(['super_id' => null]);
        $projectinfo = DB::table('project_group')->where('id', $pid)->first();
        $user = User::find(Auth::user()->id);
        $sid = $projectinfo->super_id;        
        if ($sid == null) {
            $sid = -1;
        }        
	    $ms = array(
		    'action' => 'AddProjectGroup',
            'email' => $user->email,
            'super_id' => $sid,
            'project_group_id' => $pid,
            'company_id' => $companyId,
            'company_name' => $companyName,
            'project_group_name' => $projectinfo->name,
            'project_group_Enname' => $projectinfo->enname,
        );

        $msjson = json_encode($ms, JSON_UNESCAPED_UNICODE);
        send2rabbitmq('localhost', 'secfile', $msjson);

        return Redirect::action('ProjectGroupController@showGroups',
            array('companyId' => $companyId, 'companyName' => $companyName))->with('success', '添加项目组成功！');
    }


}

