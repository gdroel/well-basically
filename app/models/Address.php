<?php
class Address extends Eloquent{
	
	protected $table = "addresses";

	public function user(){

		return $this->BelongsTo('User');
	}

	public function comments(){

		return $this->hasMany('Comment');
	}
}