<?php
use LaravelBook\Ardent\Ardent;
class ClientEndpoint extends Ardent{
	protected $table = 'oauth_client_endpoints' ;
	protected $fillable = ['client_id','redirect_uri'] ;
}