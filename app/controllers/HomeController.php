<?php

class HomeController extends BaseController {

	/**
	 * Returns home page of all the wells, the index.
	 * 
	 * @return index.blade.php View
	 */
	
	public function index(){

		/* 
		Sets the Well Variable to null, or to the current users well. Used
		for populating the well modal (not model, I'm talking about the 
		bootstrap component) with information 
		*/

		if(Auth::check()){

			if(Address::where('user_id',Auth::user()->id)->first()){
			$well = Address::where('user_id',Auth::user()->id)->first();
		}

			else{

			$well = null;

			}

		}

		//Gets all the Addresses from the database, then puts them into JSON so Javascript can read it.

		$addresses = Address::all();
		$addresses = json_encode($addresses);

		return View::make('index',compact('addresses','well'));
	}

	/**
	 *
	 *  Shows an individual well.
	 *  @param $id gets ID of well we want to show from route
	 * 	@return  View return the show well view
	 * 	
	 */

	public function showWell($id){


		$well = Address::where('id',$id)->first();

		return View::make('show-well',compact('well'));
	}

	/**
	 * Simply returns the the create view, with the well variable.
	 * 
	 * @return View Returns, create.blade.php with the well variable, which is used for populating the editing form
	 */

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

	/**
	 * Adds new Address Record to database
	 * 
	 * @return  Redirect successfully redirects to home page
	 */

	public function doCreate(){

		if(Auth::check()){

			$address = Input::get('address');
			$address = Str::slug($address,'+');

			//Sends address through Google Maps Geocoding API, which converts it to Lat and Lng Values 
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

			return Redirect::to('HomeController@index');

		}

	}

	/**
	 * Edits the address, from the address editing form
	 *
	 * @return  Redirect Redirects depending on whether validation passed
	 */

	public function doEdit(){

		$input = Input::all();
		$rules = [

			'flow_rate' => 'required|numeric',
			'year_dug' => 'required|digits:4',
			'depth' => 'required|numeric|digits_between:1,4'

		];

		$validator = Validator::make($input,$rules);

		if($validator->passes()){

			//Hidden field where we can get the well ID
			$well = Address::where('id', Input::get('well_id'))->first();

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

			//Sets session variable, we retrieve this on the index page to show the user a notification
			Session::Flash('message','Thanks for updating your well status!');

			return Redirect::action('HomeController@index');

		}

		else{
		
			return Redirect::action('HomeController@showCreate')->withInput()->withErrors($validator);

		}

	}

	/**
	 * 
	 * Super simple method, returns register view
	 * @return Register View
	 */

	public function showRegister(){

		return View::make('register');
	}

	/**
	 * Adds a user to the database, sends them an email with confirmation code
	 *
	 * @return Redirect
	 */

	public function doRegister(){

        $rules = [
            'username' => 'required|min:6|max:15|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|max:20'
        ];

        $input = Input::only(
            'username',
            'email',
            'password',
            'password_confirmation'
        );

        $validator = Validator::make($input, $rules);

        if($validator->fails()) {

            return Redirect::action('HomeController@showRegister')->withInput()->withErrors($validator);
        }
        

        $confirmation_code = str_random(30);

       	$user = new User();

        $user->username = Input::get('username');
        $user->email = Input::get('email');
        $user->password = Hash::make(Input::get('password'));
        $user->confirmation_code = $confirmation_code;
        
        $user->save();

        /*
        
        Sends with the view emails.verify, which has a link with the confirmation code.
        The user clicks the code, then, it redirects them to the confirm method. Also,
        this code sends from gdroel@gmail.com, which needs to be changed to a corporate
        account.

         */
        Mail::send('emails.verify', compact('confirmation_code'), function($message) {

            $message->to(Input::get('email'), Input::get('username'))
                ->subject('Verify your email address');
        });

        // Sets message session variable, which can be accessed in the index view.
        Session::Flash('message','Thanks for registering! Check your email to verify your account.');

        return Redirect::action('HomeController@index');
    }

    /**
     * 
     * @return View returns Login View
     */

	public function showLogin(){

		return View::make('login');

	}

	/**
	 * This method logs a user in, but has some comple complexities.
	 * For the login to be valid, the confirmed value must be equal to 1
	 * If this is equal to 0, the login will fail, because they have not
	 * clicked the verification link in their email.
	 * 
	 * @return  Redirect 
	 */

	public function doLogin(){

		$rules = array( 
		    'email'  => 'required',
		    'password' => 'required'
		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			
			return Redirect::to('login')
			->with('validation_failed', 1)
			->withErrors($validator);
	   	

		}

		else{

			$email = Input::get('email');
			$password = Input::get('password');

			if (Auth::attempt(array('email' => $email, 'password' => $password, 'confirmed'=>1)) ){

				Session::Flash('message','You have successfully logged in.');
				return Redirect::action('HomeController@index');
			}

			else{

				//If this is true, the view displays a message that says 'invalid username or password'
				$login = true;
				return View::make('login',compact('login'));
			}

		}

	}

	/**
	 * Logs people out, easy peasy
	 * 
	 * @return Redirect
	 */
	public function doLogout(){

		Auth::logout();
		Session::Flash('message','You have successfully logged out.');
		return Redirect::action('HomeController@index');
	}

	/**
	 * This method confirms the user, or in technical terms, sets the confirmed column in that row to 1
	 * If this is set to 1, then the user is confirmed, and allowed to login. This method gets the confirmation
	 * code that was sent in the email, then finds the user with the same confirmation code in the database.
	 * Finally, it sets the  confirmation code to null, because it is unneeeded.
	 * 
	 * @param  [type] $confirmation_code, Gets confirmation code from confirm route
	 * @return [type]
	 */
	
    public function confirm($confirmation_code){

        $user = User::where('confirmation_code',$confirmation_code)->first();

        $user->confirmed = 1;
        $user->confirmation_code = null;
        $user->save();

		Session::Flash('message','Your account has been confirmed.');
        return Redirect::action('HomeController@index');
    }

    public function comment(){

    	$address = Address::where('id',Input::get('address_id'))->first();

    	$comment = new Comment();

    	$comment->body = Input::get('body');
    	$comment->user_id = Input::get('user_id');
    	$comment->address_id = Input::get('address_id');

    	$address->comments()->save($comment);

    	return Redirect::back();
    }
}
