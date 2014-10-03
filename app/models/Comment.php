<?php

class Comment extends Eloquent{

	public function address(){

		return $this->belongsTo('Address');
	}

	public function user(){

		return $this->belongsTo('User');
	}
}