@extends('layout')

@section('content')


<div class="col-md-12 bg1">
	<div class="jumbotron movedownless big-p">
		<h1 class="lobster white big-text">What is Wellsio?</h1>
		<div class="col-md-8 col-md-offset-2 big-p">
		<p class="white big-p">
			Wellsio is a crowdsourced well database. Owners 
			of wells add their stats, and others can view their stats. Its basically Zillow for wells.
		</p>
		<a class="btn btn-info" href="{{ action('HomeController@showRegister') }}">Sweet, Let's get Started!</a>
		</div>
	</div>
	<div class="col-md-10 col-md-offset-1 bottom">
		<img  class="img-responsive center" src="../images/screenshot.png">
	</div>
</div>
@stop