<?php

class Comment extends Eloquent{

	public function address(){

		return $this->belongsTo('Address');
	}
}