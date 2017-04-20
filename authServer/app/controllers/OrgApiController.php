<?php


use League\OAuth2\Server\Exception\InvalidAccessTokenException;
use League\OAuth2\Server\Storage\SessionInterface;

class OrgApiController extends BaseController
{

    protected $session = null;

    public function __construct(SessionInterface $sessionObj)
    {	
    	SeasLog::info('org_api | success | '.Input::get('access_token'));
        $this->session = $sessionObj;
    }

    /**
     * 申请创建组织， 参数：applier_email、name、email、phone、address
     * @return response
     */
    public function postBuildCompany(){

        $applier_email = Input::get('applier_email');
        $name = Input::get('name');
        $email = Input::get('email');
        $phone = Input::get('phone');
        $address = Input::get('address');

        //校验参数的完整性
        if($email == null || $applier_email == null || $name == null) {

            $response = [
                'status' => 'failed',
                'error' => 'parameter is not complete'
            ];

            return Response::json($response, 401);

        }

        $applierInfo = User::getUserInfoByEmail($applier_email);

        if($applierInfo != null) {

            $companyInfo = array(
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'address' => $address,
                'applier_id' => $applierInfo[0]->id,
            );

            $company = new Company($companyInfo);
            if ($company->save(Company::$rules)) {
                $response = [
                    'status' => 'success',
                    'company_id' => $company->id,
                ];
                return Response::json($response);
                //return $response;
            }
            else{
                $response = [
                    'status' => 'failed',
                    'error' => 'build company failed',
                ];
                return Response::json($response);
            }
        }
        else{
            $response = [
                    'status' => 'failed',
                    'error' => 'verification did not pass',
                ];
            return Response::json($response);
        }

    }

    //返回所有审核通过了的公司信息, 参数：email
    public function postAllCompany(){

        $header = array('Content-type' => 'application/json; charset = utf-8');

        $email = Input::get('email');

        //校验参数的完整性
        if($email == null) {

            $response = [
                'status' => 'failed',
                'error' => 'parameter is not complete'
            ];

            return Response::json($response, 401);

        }

        $userInfo = User::getUserInfoByEmail($email);

        if($userInfo != NULL) {

            $allCompany = Company::getCompanies(1);
            $count = 0;
            foreach($allCompany as $company){
                $allCompanyInfo = array();

                $allCompanyInfo['id']    = $company->id;
                $allCompanyInfo['name']  = $company->name;
                $allCompanyInfo['email'] = strtolower($company->email);
                $allCompanyInfo['phone'] = $company->phone;
/*                $allCompany['address'] = $company->address;*/
                $count = $count +1;
                $companyUser = CompanyUser::getUser($userInfo[0]->id, $company->id);

                //type区分是否已加入   0：未加入   1：已加入
                if($companyUser != null && $companyUser->state == 1){
                    $allCompanyInfo['type'] = 1;
                }else{
                    $allCompanyInfo['type'] = 0;
                }

                $all[] = $allCompanyInfo;
            }

            if(!isset($all)){
                $all[] = array();
            }

            $response = [
                'status' => 'success',
                'total'=> $count,
                'allCompany' => $all,
            ];

            return Response::json($response,200, $header, JSON_UNESCAPED_UNICODE);

        }
        else{
            $response = [
                    'status' => 'failed',
                    'error' => 'verification did not pass',
                ];

            return Response::json($response,401, $header, JSON_UNESCAPED_UNICODE);

        }

    }

    /*申请加入某组织
     * 参数 email、company_name
    */

    public function postAddToCompany(){

        $email = Input::get('email');
        $companyName = Input::get('company_name');

        //校验参数的完整性
        if($email == null || $companyName == null) {

            $response = [
                'status' => 'failed',
                'error' => 'parameter is not complete'
            ];

            return Response::json($response, 401);

        }

        $userInfo = User::getUserInfoByEmail($email);
        $companyInfo = Company::getCompanyIdByName($companyName);


		if($companyInfo != null && $userInfo != null) {
			$companyUserInfo = array(
				'user_id' => $userInfo[0]->id,
				'company_id' => $companyInfo[0]->id,
			);

			//检查该用户是否已加入
			$existCmpUser = CompanyUser::getUser($userInfo[0]->id, $companyInfo[0]->id);

			if($existCmpUser == null){//如果该用户未加入该组织，申请加入

				$companyUser = new CompanyUser($companyUserInfo);

				if($companyUser->save()){

                    $response = [
                        'status' => 'success',
                    ];
					return Response::json($response);
				}else{
                    $response = [
                        'status' => 'failed',
                        'error'  => 'save failed',
                    ];
					return Response::json($response);
				}
			} else if($existCmpUser->state == 2){

				if(CompanyUser::updateState($existCmpUser->id,0)){
                    $response = [
                        'status' => 'success',
                    ];
					return Response::json($response);
				}else{
                    $response = [
                        'status' => 'failed',
                        'error'  => 'update failed',
                    ];
					return Response::json($response);

				}
			}
            $response = [
                        'status' => 'success',
                        'warning' => 'repeat',
                    ];
			return Response::json($response);

		}

        $response = [
            'status' => 'failed',
            'error' => 'company is not exist or user is invalid',
        ];
        return Response::json($response);

    }

    /**
     * 查询我加入的组织
     * @param email  「用户邮箱」
     *
     * @return response
     */
    public function postMyCompany(){

        $header = array('Content-type' => 'application/json; charset = utf-8');

        $email = Input::get('email');

        //校验参数的完整性
        if($email == null) {

            $response = [
                'status' => 'failed',
                'error' => 'parameter is not complete'
            ];

            return Response::json($response, 401);

        }

        $userInfo = User::getUserInfoByEmail($email);

        if($userInfo != null) {

            $companyUsers = CompanyUser::myJoin($userInfo[0]->id);
            if($companyUsers != null){
                $count = 0;
                foreach($companyUsers as $companyUser){
                    $company = Company::find($companyUser->company_id);

                    $allCompanyInfo = array();

                    $allCompanyInfo['id']    = $company->id;
                    $allCompanyInfo['name']  = $company->name;
                    $allCompanyInfo['email'] = strtolower($company->email);
                    $allCompanyInfo['phone'] = $company->phone;
                    
                    $count = $count +1;
                    /*                $allCompany['address'] = $company->address;*/

                    $all[] = $allCompanyInfo;
                }
            }

            if(!isset($all)){
                $all[] = array();
            }

            $response = [
                'status' => 'success',
                'total' => $count,
                'allCompany' => $all,
            ];

            return Response::json($response,200, $header, JSON_UNESCAPED_UNICODE);

        }
        else{
            $response = [
                    'status' => 'failed',
                    'error' => 'verification did not pass',
                ];

            return Response::json($response,401, $header, JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * 查询组织成员信息
     * @param email 「用户邮箱」
     * @param company_id 「公司id」
     * @param state 「成员状态」
     * @return mixed
     */
    public function postContacts(){

        //return Response::json(['test'=>'ok'], 200);
        $header = array('Content-type' => 'application/json; charset = utf-8');
        $name = Input::get('company_name');
        $userEmail = Input::get('email');
        if($userEmail == null || $name == null) {

            $response = [
                'status' => 'failed',
                'error' => 'parameter is not complete'
            ];

            return Response::json($response, 401);

        }
	
        $companyIdObject = Company::getCompanyIdByName($name);
        if ($companyIdObject == null){
            $response = [
                'status' => 'failed',
                'error' => 'company not exist'
            ];
	    return Response::json($response, 401);
        }
        $companyId= $companyIdObject[0]->id;
      
    //    $companyId = Input::get('company_id');
        $state = Input::get('state');

        if(!isset($state) || $state == null){
            $state = 1;
        }


        $user = User::getUserInfoByEmail($userEmail);
        $company = Company::find($companyId);


        if($user!=null && $company!=null && $company->state == 1) {

            //判断用户是否是组织成员
            $companyUser = CompanyUser::getUser($user[0]->id, $companyId);

            if($companyUser != null && $companyUser->state == 1){

                //返回通讯录信息
                $companyUsers = CompanyUser::getAllUserByCondition($companyUser->company_id, $state);

                foreach($companyUsers as $companyUser){
                    $eachUser = User::find($companyUser->user_id);
                    $allUser[] = array(
                        'username' => $eachUser->username,
                        'email' => strtolower($eachUser->email),
                        'address' => $eachUser->address,
                        'user_category'=> $eachUser->user_category,
                        'phone' => $eachUser->phone,
                    );
                }
                if(!isset($allUser)){
                    $allUser = array();
                }

                $response = [
                    'status' => 'success',
                    'allUser' => $allUser,
                ];

                return Response::json($response,200, $header, JSON_UNESCAPED_UNICODE);

            }

            $response = [
                'status' => 'failed',
                'error' => 'company and user do not match',
            ];

            return Response::json($response,401, $header, JSON_UNESCAPED_UNICODE);

        }

        $response = [
            'status' => 'failed',
            'error' => 'verification did not pass',
        ];

        return Response::json($response,401, $header, JSON_UNESCAPED_UNICODE);

    }

    /**
     * 退出组织
     * @param email 「用户邮箱」
     * @param company_id 「公司id」
     *
     */
    public function exitOrg(){

        $userEmail = Input::get('email');
        $companyId = Input::get('company_id');

        //校验参数的完整性
        if($userEmail == null || $companyId == null) {

            $response = [
                'status' => 'failed',
                'error' => 'parameter is not complete'
            ];

            return Response::json($response, 401);

        }

        $user = User::getUserInfoByEmail($userEmail);
        $company = Company::find($companyId);

        if($user != null && $company != null && $company->state == 1) {

            $companyUser = CompanyUser::getUser($user[0]->id, $companyId);
            if($companyUser != null && $companyUser->state == 1){
                CompanyUser::deleteCmpUser($user[0]->id, $companyId);

                $response = [
                    'status' => 'success'
                ];

                //组织关系修改, 发送消息到队列
                $exchange = 'org';
                $routeKey = 'org.change.'.$companyId;
                $message = '{"type":2_2 , "email":"'.strtolower($userEmail).'", "group_id":"", "company_id":"'.$companyId.'", "message":"the member exit the org"}';

                RabbitMQ::publish($exchange, $routeKey, $message);

                return Response::json($response,200);
            }

            $response = [
                'status' => 'failed',
                'error' => 'user not belongs to organization',
            ];

            return Response::json($response,401);

        }

        $response = [
            'status' => 'failed',
            'error' => 'verification did not pass',
        ];

        return Response::json($response,401);

    }

    /**
     * 申请成为管理员
     * @param  applier_email  「申请人邮箱」
     * @param  reason   「申请理由」
     * @param  company_id   「申请的公司id」
     *
     * @return response
     */
    public function postApplyAdmin(){

        $applier_email = Input::get('applier_email');
        $reason = Input::get('reason');
        $companyId = Input::get('company_id');

        //校验参数的完整性
        if($applier_email == null || $companyId == null) {

            $response = [
                'status' => 'failed',
                'error' => 'parameter is not complete'
            ];

            return Response::json($response, 401);

        }

        $applierInfo = User::getUserInfoByEmail($applier_email);
        //$company = Company::find($company_id);

        if($applierInfo != null) {

            $adminApply = AdminApply::getApply($applierInfo[0]->id, $companyId);
            if($adminApply != null){

                switch($adminApply->state){
                    case 0:
                        $response = [
                            'status' => 'success'
                        ];
                        return Response::json($response,200);
                    case 1:
                        $response = [
                            'status' => 'failed',
                            'error' => 'you are almost the admin of org'
                        ];
                        return Response::json($response,401);
                    case 2:
                        AdminApply::updateApply($adminApply->id, $reason, 0);
                        break;
                }

            } else {
                $applyInfo = array(
                    'company_id' => $companyId,
                    'user_id' 	 => $applierInfo[0]->id,
                    'reason'	 => $reason,
                );

                $apply = new AdminApply($applyInfo);
                $apply->save(AdminApply::$rules);

                $response = [
                    'status' => 'success'
                ];

                return Response::json($response,200);
            }

        }

        $response = [
            'status' => 'failed',
            'error' => 'verification did not pass'
        ];

        return Response::json($response, 401);
    }

    /**
     * 创建项目组
     * @param name        「项目组名」
     * @param company_id  「公司id」
     * @param email       「创建人邮箱」
     * @param super_id    「上级组id」
     *
     */
    public function buildGroup(){

        $name = Input::get('name');
        $companyId = Input::get('company_id');
        $email = Input::get('email');
        $superId = Input::get('super_id');

        //校验参数的完整性
        if($email == null || $name == null || $companyId == null) {

            $response = [
                'status' => 'failed',
                'error' => 'parameter is not complete'
            ];

            return Response::json($response, 401);

        }

        $user = User::getUserInfoByEmail($email);

        if($user != null) {

            //
            if($superId != null){

                //检查新建组和父组是否属于同一公司
                $superGroup = ProjectGroup::find($superId);
                $superCompany = $superGroup->company;

                if($superCompany->id != $companyId) {

                    $response = [
                        'status' => 'failed',
                        'error' => 'group and the parent is not in the same company',
                    ];

                    return Response::json($response, 401);
                }

                //建立子项目
                $projectGroupInfo = array(
                    'company_id' => $companyId,
                    'name'	=> $name,
                    'super_id' => $superId,
                );

                $existGroup = ProjectGroup::queryByCondition($companyId, $superId, $name);

            } else {
                //创建一级项目
                $projectGroupInfo = array(
                    'company_id' => $companyId,
                    'name'			=> $name,
                );

                $existGroup = ProjectGroup::queryByCondition($companyId, null, $name);

            }

            if($existGroup != null){
                $response = [
                    'status' => 'failed',
                    'error' => 'project group has existed in the org'
                ];

                return Response::json($response, 401);
            }

            $projectGroup = new ProjectGroup($projectGroupInfo);
            if($projectGroup->save(ProjectGroup::$rules)){

                $response = [
                    'status' => 'success',
                    'project_group_id' => $projectGroup->id,
                ];

                //组织关系修改, 发送消息到队列
                $exchange = 'org';
                $routeKey = 'org.change.'.$companyId;
                $message = '{"type":1_0, "email":"'.strtolower($email).'", "group_id":"'.$projectGroup->id.'", "company_id":"'.$companyId.'", "message":"add a new group"}';

                RabbitMQ::publish($exchange, $routeKey, $message);

                return Response::json($response, 200);
            }

        }

        $response = [
            'status' => 'failed',
            'error' => 'verification did not pass'
        ];

        return Response::json($response, 401);

    }

    /**
     * 成员派遣
     * @param email  「当前用户邮箱」
     * @param employee_email  「员工邮箱」
     * @param project_group_id 「项目组id」
     *
     */
    public function distributeMember(){

        $email = Input::get('email');
        $employeeEmail = Input::get('employee_email');
        $projectGroupId = Input::get('project_group_id');

        //校验参数的完整性
        if($email == null || $employeeEmail == null || $projectGroupId == null) {

            $response = [
                'status' => 'failed',
                'error' => 'parameter is not complete'
            ];

            return Response::json($response, 401);

        }

        $user = User::getUserInfoByEmail($email);

        if($user != null){

            //检查当前用户是否是组成员
            $groupMember = ProjectGroupMember::queryByUid($projectGroupId, $user[0]->id);
            if($groupMember == null){

                $response = [
                    'status' => 'failed',
                    'error' => 'inviter is not the member of group',
                ];

                return Response::json($response, 401);
            }

            $employee = User::getUserInfoByEmail($employeeEmail);

            //检查要加入的组是否存在
            $projectGroup = ProjectGroup::find($projectGroupId);
            if($projectGroup == null) {

                $response = [
                    'status' => 'failed',
                    'error' => 'the group is not exist',
                ];

                return Response::json($response, 401);

            }

            //检查要加入组的成员是否是网络帐号用户
            if($employee == null){

                $response = [
                    'status' => 'failed',
                    'error' => 'the employee is not the network account',
                ];

                return Response::json($response, 401);
            }

            //检查该用户是否已经加入项目组
            $member = ProjectGroupMember::queryByUid($projectGroupId, $employee[0]->id);

            if($member == null) {
                $memberInfo = array(
                    "project_group_id" => $projectGroupId,
                    "user_id" => $employee[0]->id,
                );
                $member = new ProjectGroupMember($memberInfo);
                $member->save(ProjectGroupMember::$rules);
            }

            $response = [
                'status' => 'success',
                'member_id' => $member->id,
            ];

            $projectGroup = ProjectGroup::find($projectGroupId);

            //组织关系修改, 发送消息到队列
            $exchange = 'org';
            $routeKey = 'org.change.'.$projectGroup->company_id;
            $message = '{"type":2_2, "email":"'.strtolower($email).'", "group_id":"'.$projectGroupId.'", "company_id":"'.$projectGroup->company_id.'", "message":"join a group"}';

            RabbitMQ::publish($exchange, $routeKey, $message);


            return Response::json($response, 200);

        }

        $response = [
            'status' => 'failed',
            'error' => 'verification did not pass'
        ];

        return Response::json($response, 401);

    }

    /**
     * 删除成员
     * @param email  「当前用户邮箱」
     * @param project_group_id  「项目组id」
     * @param member_id  「成员id」
     *
     */
    public function deleteMember(){

        $email = Input::get('email');
        $memberId = Input::get('member_id');
        $projectGroupId = Input::get('project_group_id');

        //校验参数的完整性
        if($email == null || $memberId == null || $projectGroupId == null) {

            $response = [
                'status' => 'failed',
                'error' => 'parameter is not complete'
            ];

            return Response::json($response, 401);

        }

        $user = User::getUserInfoByEmail($email);

        if($user != null) {

            //检查当前用户是否是公司管理员
            $projectGroup = ProjectGroup::find($projectGroupId);
            $company = $projectGroup->company;

            $companyUser = CompanyUser::isCompanyAdmin($user[0]->id, $company->id);

            if($companyUser == null){
                $response = [
                    'status' => 'failed',
                    'error' => 'permission forbid',
                ];

                return Response::json($response, 403);
            }

            //检查组是否存在
            $projectGroup = ProjectGroup::find($projectGroupId);
            if($projectGroup == null) {

                $response = [
                    'status' => 'failed',
                    'error' => 'the group is not exist',
                ];

                return Response::json($response, 401);

            }

            ProjectGroupMember::deleteMemberById($memberId);

            $response = [
                'status' => 'success'
            ];

            $projectGroup = ProjectGroup::find($projectGroupId);

            //组织关系修改, 发送消息到队列
            $exchange = 'org';
            $routeKey = 'org.change.'.$projectGroup->company_id;
            $message = '{"type":2_1, "email":"'.strtolower($email).'", "group_id":"'.$projectGroupId.'", "company_id":"'.$projectGroup->company_id.'", "message":"exit a group"}';

            RabbitMQ::publish($exchange, $routeKey, $message);

            return Response::json($response, 200);

        }

        $response = [
            'status' => 'failed',
            'error' => 'verification did not pass'
        ];

        return Response::json($response, 401);

    }

    /**
     * 获取组织结构
     * @param email 「当前用户邮箱」
     * @param company_id 「公司id」
     * edited by qianxi, 2016-03-24 09:30:19
     */
    public function userList(){
        $header = array('Content-type' => 'application/json; charset = utf-8');
        $email = Input::get('email');
        $limit = Input::get('limit', 0);
        $offset = Input::get('offset', 0);
        if($email == null || $limit < 0 || $offset < 0) {
            $response = [
                'status' => 'failed',
                'error' => 'parameter is not complete'
            ];
            return Response::json($response, 401);
        }
        $user = User::getUserInfoByEmail($email);
        if($user == null){
            $response = [
                'status' => 'failed',
                'error' => 'email not exist'
            ];
            return Response::json($response, 401);
            }
        $userList = User::getListByEmail($email,$offset,$limit);
        $total = count($userList);
    /*   foreach($userList as $allUserInfo){
                $all = array();
                $all['username'] = $allUserInfo->username;
                $all['name'] = $allUserInfo->name;
                $all['photo'] = $allUserInfo->portrait;
                $all['userId'] = $allUserInfo->id;
                $all['sex'] = $allUserInfo->sex;
                $all['phone'] = $allUserInfo->phone;
                $all['address'] = $allUserInfo->address;
                $all['email'] = $allUserInfo->email;
                $allIn[] = $all;              
            } */
            //   if ($limit == 0) $limit = $total;
       $response = [
                'status' => 'success',
                'total'  => $total,
                'users'  => $userList
            ];
       return Response::json($response, 200, $header, JSON_UNESCAPED_UNICODE);
       

       
    } 




    public function groupInOrg(){
        $header = array('Content-type' => 'application/json; charset = utf-8');
        $name = Input::get('company_name');
        $email = Input::get('email');
        //�| ���~L�~O~B�~U��~Z~D��~L�~U��~@�
        if($name == null || $email == null) {
            $response = [
                'status' => 'failed',
                'error' => 'parameter is not complete'
            ];
            return Response::json($response, 401);
        }
        $user = User::getUserInfoByEmail($email);
        if($user!= null){
            //��~@�~_���~D��~G�~X��~P���~X�~\�
            $companyName = Company::getCmpInfoByName($name);
            $companyId = Company::getCompanyIdByName($name);
            
            if($companyName == null || $companyId ==null){      
                $response = [
                    'status' => 'failed',
                    'error' => 'org not exist'
                ];
                return Response::json($response, 401);
            }
            $groupList = ProjectGroup::listGroups($companyId[0]->id,null);
          //  var_dump($groupList);
          /*  var_dump($companyId[0]->id);*/
            if($groupList==null){
             $response = [
                  'status' => 'success',
                  'groupInfo' => 'no group exist',
              ];
              return Response::json($response, 200, $header, JSON_UNESCAPED_UNICODE);

            }
            $total = count($groupList); 

            foreach($groupList as $group){
                $allGroup = array();
                $allGroup['id'] = $group->id;
                $allGroup['name'] = $group->name;
                $allGroup['enname'] = $group->enname;
                $all[] = $allGroup;
            }
            $response = [
                'status' => 'success',
                'total'  => $total,
                'groupInfo' => $all,
            ];
            return Response::json($response, 200, $header, JSON_UNESCAPED_UNICODE);
        }
        $response = [
            'status' => 'failed',
            'error' => 'verification did not pass'
        ];
        return Response::json($response, 401);
    }

    public function personInGroup(){
        $header = array('Content-type' => 'application/json; charset = utf-8');
        $name = Input::get('company_name');
        $gname = Input::get('group_name');
        $email = Input::get('email');
        //�| ���~L�~O~B�~U��~Z~D��~L�~U��~@�
        if($name == null || $email == null||$gname== null) {
            $response = [
                'status' => 'failed',
                'error' => 'parameter is not complete'
            ];
            return Response::json($response, 401);
        }

        $user = User::getUserInfoByEmail($email);
        if($user!= null){
            //��~@�~_���~D��~G�~X��~P���~X�~\�
            $companyName = Company::getCmpInfoByName($name);
            $companyId = Company::getCompanyIdByName($name);
            if($companyName == null || $companyId ==null){
                $response = [
                    'status' => 'failed',
                    'error' => 'org not exist'
                ];
                return Response::json($response, 401);
                
            }
           
            $groupList = ProjectGroup::listGroups($companyId[0]->id,null);
            $exist = 0;
            $gId = 0;
            foreach($groupList as $group){
                if($gname==($group->name)){
                    $gId=$group->id;
                    $exist = 1;
                    break;                 
                }
              /*  continue;*/
            }
            if($exist==1){   
                $members = ProjectGroupMember::listMembers($gId);
                //   var_dump($members);
                $total = count($members);      
                foreach($members as $member){
                /*  var_dump($member->user_id);*/
                    $userType = array();
               //     var_dump($member->type);
                    $userType['type'] = ($member->type); 
                    $type[] = $userType;
                    $all[] = User::getUserInfoById($member->user_id);
                    //   $aaaa[] = array_merge($type, $all);  
                }
                //  var_dump($members);
                //     var_dump($aaaa);
                foreach($all as $alls){
                    $allUsers = array();
                    $allUsers['name'] =($alls[0]->username);
                    $allUsers['id'] = ($alls[0]->id);
                    $allUsers['email'] = ($alls[0]->email);
                    $allUsers['user_category'] = ($alls[0]->user_category);
           //       $allUsers['type'] = " ";
                    $end[] = $allUsers;
                }
            //        var_dump($type);
             //     var_dump($members);
             //     var_dump($end);
                    $loop = 0;
                foreach($type as $types){
         //         var_dump($types[0]->type);
                    $end[$loop]['type']= $types['type'];
                    $loop = $loop+1;
                  } 

              
                //      $c =array_combine($type,$end);
                $response = [
                'status' => 'success',
                'total'  => $total,
         //     'membersInfo' => $members,
                'membersInfo' => $end,
            ];
                return Response::json($response, 200, $header, JSON_UNESCAPED_UNICODE);
            }
            $response = [
                'status' => 'failed',
                'error' => 'group not exist'
                ];
            return Response::json($response, 401);
        }
    }
 









    public function orgStructure(){

        $header = array('Content-type' => 'application/json; charset = utf-8');
        $name = Input::get('company_name');
      //  var_dump($name);
        $companyIdObject = Company::getCompanyIdByName($name);
        $companyId= $companyIdObject[0]->id;
      //  $companyId = Input::get('company_id');
        $email = Input::get('email');

        //校验参数的完整性
        if($companyId == null || $email == null) {

            $response = [
                'status' => 'failed',
                'error' => 'parameter is not complete'
            ];

            return Response::json($response, 401);

        }

        $user = User::getUserInfoByEmail($email);

        if($user != null){

            //检查组织是否存在
            $company = Company::find($companyId);
            if($company == null || $company->state != 1){

                $response = [
                    'status' => 'failed',
                    'error' => 'org not exist'
                ];

                return Response::json($response, 401);
            }

            //检查用户是否属于该组织
            $companyUser = CompanyUser::getUser($user[0]->id, $companyId);
            if($companyUser == null || $companyUser->state != 1){

                $response = [
                    'status' => 'failed',
                    'error' => 'you are not the member of org'
                ];

                return Response::json($response, 401);
            }

            $result = $this->recursiveGroup($companyId, null);

            $companyInfo = array(
                'id' => $companyId,
                'name' => $company->name,
                'email' => strtolower($company->email),
                'phone' => $company->phone,
                'state' => $company->state,
                'groupInfo' => $result,
            );

            $response = [
                'status' => 'success',
                'companyInfo' => $companyInfo,
            ];

            return Response::json($response, 200, $header, JSON_UNESCAPED_UNICODE);

        }

        $response = [
            'status' => 'failed',
            'error' => 'verification did not pass'
        ];

        return Response::json($response, 401);

    }

    /**
     * 递归查询组与组成员信息
     * @param $companyId  「公司id」
     * @param $superId  「上级组id」
     */
    private function recursiveGroup($companyId, $superId){

        $groupList = ProjectGroup::listGroups($companyId, $superId);

        foreach($groupList as $group){

            $members = ProjectGroupMember::listMembers($group->id);

            //初始化变量
            $users = array();//dd(['members'=>$members, 'companyId'=>$companyId, 'group'=>$group]);

            foreach($members as $member) {
                $user = User::find($member->user_id);
                if ($user == null) {dd($member->user_id);}
                $users[] = array(
                    'userId' => $user->id,
                    'username' => $user->username,
                    'name' => $user->name,
                    'email' => strtolower($user->email),
                    'user_category' => $user->user_category,
                    'phone' => $user->phone,
                    'memberType' => $member->type,
                );
            }

            //检查项目组是否有子项目组,如有,先查询子项目组信息
            $sonGroups = ProjectGroup::listGroups($companyId, $group->id);

            //初始化变量
            $sonArr = array();
            if($sonGroups != null){
                $sonArr = $this->recursiveGroup($companyId, $group->id);
            }
			
			if ($group->super_id == null) {
				$group->super_id = -1;
			}
            $arr[] = array(
                'groupId' => $group->id,
                'groupName' => $group->name,
                'members' => $users,
                'sonGroups' => $sonArr,
                'enname' => $group->enname,
                'leaf' => $group->leaf,
                'superId' =>$group->super_id,
            );

        }

        if(!isset($arr)){
            $arr = array();
        }

        return $arr;

    }

    /**
     * 查询个人组织关系
     * @param email 「邮箱」
     */
    public function personOrg(){

        $header = array('Content-type' => 'application/json; charset = utf-8');

        $email = Input::get('email');

        //校验参数的完整性
        if($email == null) {

            $response = [
                'status' => 'failed',
                'error' => 'parameter is not complete'
            ];

            return Response::json($response, 401);

        }

        $user = User::getUserInfoByEmail($email);

        if($user != null){

            //
            $members = ProjectGroupMember::findByUid($user[0]->id);
            $count = 0;
            foreach($members as $member){

                $cmpInfo = $this->personRecursive($member->project_group_id, $member);

                $companyInfo[] = $cmpInfo;
                $count = $count +1;
            }

            if(!isset($companyInfo)){
                $companyInfo = array();
            }

            $response = [
                'status' => 'success',
                'companyInfo' => $companyInfo,
            ];

            return Response::json($response, 200, $header, JSON_UNESCAPED_UNICODE);

        }

        $response = [
            'status' => 'failed',
            'error' => 'verification did not pass'
        ];

        return Response::json($response, 401);

    }

    /**
     * 查询个人项目组关系
     */
    private function personRecursive($projectId, $member){

        $projectGroup = ProjectGroup::find($projectId);

        $groupInfo = array();

        do{

            //封装子项目组信息
            if(empty($groupInfo)){

                $sonGroup = array(
                    'groupId' => $projectGroup->id,
                    'groupName' => $projectGroup->name,
                    'enname' => $projectGroup->enname,
                    'memberType' => $member->type,
                );

            } else {

                $sonGroup = array(
                    'groupId' => $projectGroup->id,
                    'groupName' => $projectGroup->name,
                    'enname' => $projectGroup->enname,
                    'sonGroup' => $groupInfo,
                );

            }

            $groupInfo = $sonGroup;


        } while ($projectGroup->super_id != null && ($projectGroup = ProjectGroup::find($projectGroup->super_id)) != null);

        $company = Company::find($projectGroup->company_id);

        $companyInfo = array(
            'id' => $company->id,
            'name' => $company->name,
            'email' => strtolower($company->email),
            'phone' => $company->phone,
            'state' => $company->state,
            'groupInfo' => $groupInfo,
        );

        return $companyInfo;

    }

    /**
     * 审核组织成员
     */
    public function checkOrgUser(){

        $email = Input::get('email');
        $companyId = Input::get('company_id');
        $applierEmail = Input::get('applier_email');
        $state = Input::get('state');

        //校验参数的完整性
        if($email == null || $companyId == null || $applierEmail == null || $state == null) {

            $response = [
                'status' => 'failed',
                'error' => 'parameter is not complete'
            ];

            return Response::json($response, 401);

        }

        $user = User::getUserInfoByEmail($email);

        if($user != null){

            //检查当前用户是否是公司管理员
            $companyUser = CompanyUser::isCompanyAdmin($user[0]->id, $companyId);

            if($companyUser == null){
                $response = [
                    'status' => 'failed',
                    'error' => 'permission forbid',
                ];

                return Response::json($response, 403);
            }

            $applier = User::getUserInfoByEmail($applierEmail);

            if($applier != null){
                if($state == 1 || $state == 2){
                    CompanyUser::updateStateByCondition($applier[0]->id,$companyId, $state);
                } else {
                    $response = [
                        'status' => 'failed',
                        'error' => 'state is invalid'
                    ];

                    return Response::json($response, 401);
                }

            }

            $response = [
                'status' => 'success'
            ];

            return Response::json($response);

        }

        $response = [
            'status' => 'failed',
            'error' => 'verification did not pass'
        ];

        return Response::json($response, 401);


    }

    /**
     * 根据项目组id获取项目组信息
     */
    public function groupInfo(){
        $header = array('Content-type' => 'application/json; charset = utf-8');

        $email = Input::get('email');
        $projectGroupId = Input::get('project_group_id');

        //校验参数的完整性
        if($email == null || $projectGroupId == null) {

            $response = [
                'status' => 'failed',
                'error' => 'parameter is not complete'
            ];

            return Response::json($response, 401);

        }

        $userInfo = User::getUserInfoByEmail($email);

        if($userInfo != null) {

            $projectGroup = ProjectGroup::find($projectGroupId);
			if ($projectGroup->super_id == null) {
				$projectGroup->super_id = -1;
			}
            $projectGroupInfo = array(
                'id' => $projectGroup->id,
                'name' => $projectGroup->name,
                'enname' => $projectGroup->enname,
                'company_id' => $projectGroup->company_id,
                'super_id' => $projectGroup->super_id,
            );

            $response = [
                'status' => 'success',
                'projectGroup' => $projectGroupInfo,
            ];

            return Response::json($response,200, $header, JSON_UNESCAPED_UNICODE);

        }
        else{
            $response = [
                'status' => 'failed',
                'error' => 'verification did not pass',
            ];

            return Response::json($response,401, $header, JSON_UNESCAPED_UNICODE);
        }
    }
    
    /**
     * 根据用户email和company_id获取所影响的项目组信息
     */
    public function userInGroups()
    {
        $header = array('Content-type' => 'application/json; charset = utf-8');
        
        $projectGroupId = Input::get("project_group_id");
        $email = Input::get('email');
        $companyId = Input::get('company_id');
        $results = array();
        $groupResults = array();
        //校验参数的完整性
        if ($email == null || $companyId == null || $projectGroupId == null) {

            $response = [
                'status' => 'failed',
                'error' => 'parameter is not complete'
            ];

            return Response::json($response, 401);

        }

		$userInfo = User::getUserInfoByEmail($email);
        if($userInfo != null) {
            $projectGroup = ProjectGroup::find($projectGroupId);
            $rgroup[] = $projectGroup;
            ProjectGroupMember::getProjectGroupsByUser($rgroup, $results);
            $results[] = $projectGroup;

            foreach ($results as $result) {
                $groupResults[] = array(
                    'project_group_id' => $result->id,
                    'project_group_name' => $result->name,
                    'project_group_enname' => $result->enname,
                    'project_group_leaf' => $result->leaf,
                );
            }

            $response = [
                'status' => 'success',
                'projectGroups' => $groupResults,
            ];

            return Response::json($response,200, $header, JSON_UNESCAPED_UNICODE);

        }
        else{
            $response = [
                'status' => 'failed',
                'error' => 'verification did not pass',
            ];

            return Response::json($response,401, $header, JSON_UNESCAPED_UNICODE);
        }

    }

}
