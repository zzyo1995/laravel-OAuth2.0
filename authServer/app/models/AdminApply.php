<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use LaravelBook\Ardent\Ardent;
use Carbon\Carbon;

class AdminApply extends Ardent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'admin_apply';

	protected $guarded = array();

	public static $errorMessages = array(

	) ;

	public static $rules = array(
		'user_id' => 'required',
		'company_id' => 'required'
	);

	public function company(){
		return $this->belongsTo('Company');
	}

	public static function getApply($userId, $companyId){
		return DB::table('admin_apply')->where('user_id', $userId)->where(
			function($query) use ($companyId) {
				$query->where('company_id', $companyId);
			}
		)->first();
	}

	public static function updateApply($id, $reason, $state){
		return DB::table('admin_apply')->where('id', $id)->update(array('reason' => $reason, 'state' => $state));
	}

	public static function getAppliesByState($state){
		return DB::table('admin_apply')->where('state', $state)->get();
	}

	public static function updateState($id, $state){
		return DB::table('admin_apply')->where('id', $id)->update(array('state' => $state));
	}

}
