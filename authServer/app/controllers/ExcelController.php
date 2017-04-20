<?php
use Illuminate\Http\Request;
use App\Http\Requests;
use Excel;
class ExcelController extends Controller
{
	public static function export($companyUsersE){
		$companyUsers = $companyUsersE;
		foreach($companyUsers as $companyUser){
			$allUser[] = User::find($companyUser->user_id);

		}
		if(!isset($allUser)){
			$allUser[] = array();
			return;
		}
		$count = 0;
	foreach ($allUser as $key => $value) {
		
		$count++;
		$ugroup = DB::table('project_group_member')
                ->join('project_group', 'project_group.id', '=', 'project_group_member.project_group_id')
                ->where('project_group_member.user_id', $value->id)
				->select('name')->get();
		$arr = array();
		foreach ($ugroup as $k => $v) {
			
			$arr[] = $v->name;
		}
		$gp = implode("|", $arr);
        $gtmp = DB::table('oauth_roles')->where('name', $value->user_category)->pluck('description');
		$export[] = array(
		'编号' => $count, 
		'姓名' => trim($value->username),
		'邮箱' => $value->email,
		'手机' => $value->phone,
		'用户类型' => $gtmp,
		'分机号' => $value->extension_number,
		'房间号' => $value->room_number,
		'部门' => $gp,
		'备注' => $value->remark,
);
	// $cid = $_SESSION['id'];
	}
    Excel::create('企业人员通讯录',function($excel) use ($export){
      $excel->sheet('score', function($sheet) use ($export){
		$sheet->setAutoFilter();
		$sheet->setAutoSize(array(
    		'G'
		));
		$sheet->mergeCells('A1:H1');
		$sheet->row(1,array('企业人员通讯录'));
		$sheet->cells('A1:H1', function($cells) {
			$cells->setAlignment('center');
			$cells->setFontSize(20);
		});

		$sheet->cells('A:F', function($cells) {
			$cells->setAlignment('left');
		});
		$sheet->row(2,array('编号','姓名','邮箱','手机','用户类型','分机号','房间号','部门','备注'));
        $sheet->rows($export);
		$sheet->setHeight(1,30);
		$sheet->setHeight(2,25);
		$i = 2;
		foreach ($export as $e) {
			$i = $i+1;
			$sheet->setHeight($i,20);
		}
		//$sheet->setAutoSize(false);
		$sheet->setWidth(array(
			'A'     =>  10,
    		'B'     =>  15,
    		'C'     =>  30,
    		'D'     =>  15,
    		'E'     =>  10,
    		'F'     =>  15,
    		'G'     =>  10,
    		'H'     =>  35,
    		'I'     =>  15
		));
      });
    })->export('xls');
  }
}
