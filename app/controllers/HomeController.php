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

		if(Auth::check()){

			if(Address::where('user_id',Auth::user()->id)->first()){

			$well = Address::where('user_id',Auth::user()->id)->first();
		}

			else{

			$well = null;

			}

		}

		$addresses = Address::all();
		$addresses = json_encode($addresses);

		return View::make('index',compact('addresses','well'));
	}

	public function showCreate(){

		if(Auth::check()){

			if(Address::where('user_id',Auth::user()->id)->first()){

			$well = Address::where('user_id',Auth::user()->id)->first();
		}

			else{

			$well = null;

			}

		}
		return View::make('create',compact('well'));
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
		$address->year_dug = Input::get('year_dug');
		$address->user_id = Auth::user()->id;
		$address->save();

		return Redirect::to('/');

	}

	public function doEdit(){

		$well = Address::where('address',Input::get('address'))->first();

		$address = Input::get('address');
		$address = Str::slug($address,'+');

		$response = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$address.'&key=AIzaSyBoaSu9IZTRrCkY1tTnMibgHg-uwB8aduk');
		$response = json_decode($response,true);
		$results = $response['results'];

		$well->address = $results[0]['formatted_address'];
		$well->lng = $results[0]['geometry']['location']['lng'];
		$well->lat = $results[0]['geometry']['location']['lat'];
		$well->depth = Input::get('depth');
		$well->flow_rate = Input::get('flow_rate');
		$well->year_dug = Input::get('year_dug');
		$well->user_id = Auth::user()->id;
		$well->save();

		return Redirect::action('HomeController@index');

	}

	public function showRegister(){

		return View::make('register');
	}

	public function doRegister(){

		$user = new User();

		$user->username = Input::get('username');
		$user->email = Input::get('email');
		$user->password = Hash::make(Input::get('password'));

		$user->save();

		return Redirect::to('/');
	}

	public function showLogin(){

		return View::make('login');

	}

	public function doLogin(){

	$email = Input::get('email');
	$password = Input::get('password');

	if (Auth::attempt(array('email' => $email, 'password' => $password)))
		{
		    return Redirect::to('/');
		}
	
	else{
		return Redirect::to('login');
	}

	}

	public function doLogout(){

		Auth::logout();
		return Redirect::action('HomeController@index');
	}
}
