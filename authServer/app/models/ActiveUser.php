<?php

//use Carbon\Carbon;

class ActiveUser extends Eloquent {

	protected $table = 'active_users';
	protected $primaryKey = 'user_id';

	public function __construct()
	{
		$this->persistent = 0;
	}

    public function user()
    {

/*		$exprieTime = array( Carbon::createFromTimestamp(time()-12*5*60) );
		DB::delete( 'delete from active_users where updated_at < ? ' , $exprieTime);*/

/*		$exprieTime = Carbon::createFromTimestamp(time()-12*5*60);
		DB::table('active_users')->where('updated_at', '<', $exprieTime)->delete();*/

		return $this->belongsTo('User');
    }

}