<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', 'HomeController@index');

Route::get('well/{id}','HomeController@showWell');

Route::get('/create', array('before'=>'auth','uses'=>'HomeController@showCreate'));
Route::post('/create','HomeController@doCreate');

Route::get('/register','HomeController@showRegister');
Route::post('/register','HomeController@doRegister');

Route::get('/login','HomeController@showLogin');
Route::post('/login', array('as' => 'login', 'uses' => 'HomeController@doLogin'));

Route::post('/edit',array('before'=>'auth', 'uses'=> 'HomeController@doEdit'));
Route::get('/logout',array('before'=>'auth', 'uses'=> 'HomeController@doLogout'));

Route::get('/confirm/{confirmation_code}','HomeController@confirm');

Route::get('about',function(){

	return View::make('about');
});

Route::controller('password', 'RemindersController');