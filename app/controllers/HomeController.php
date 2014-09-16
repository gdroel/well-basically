<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/
	public function index(){

		$addresses = Address::all();
		$addresses = json_encode($addresses);

		return View::make('index',compact('addresses'));
	}

	public function showCreate(){

		return View::make('create');
	}

	public function doCreate(){

		$address = Input::get('address');
		$address = Str::slug($address,'+');


		$response = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$address.'&key=AIzaSyBoaSu9IZTRrCkY1tTnMibgHg-uwB8aduk');
		$response = json_decode($response,true);
		$results = $response['results'];

		$address = new Address();
		$address->address = $results[0]['formatted_address'];
		$address->lng = $results[0]['geometry']['location']['lng'];
		$address->lat = $results[0]['geometry']['location']['lat'];
		$address->depth = Input::get('depth');
		$address->flow_rate = Input::get('flow_rate');
		$address->save();

		return Redirect::to('/');

	}

}
