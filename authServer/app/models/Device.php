<?php

class Device extends Eloquent {

	protected $table = 'devices';

	protected $hidden = array('secret');

	public function getDescription() {
		return $this->description;
	}

	public function getSecret() {
		return $this->secret;
	}
	
}