@extends('layout')

@section('content')
<div class="col-xs-12 bg3">
	<div class="col-md-4 col-md-offset-4 movedown login-box">
	<h2>Login</h2>
	<hr>
	@if($errors->has())
	   @foreach ($errors->all() as $error)
	      <div class="alert alert-danger" role="alert">{{ $error }}</div>
	  @endforeach
	@endif


	@if(isset($login))
		<div class="alert alert-danger">Invalid Username or Password</div>
	@endif
	{{ Form::open(array('action'=>'HomeController@doLogin'))}}
	{{ Form::label('email','Enter your Email Address')}}
	{{ Form::text('email',null,array('class'=>'form-control')) }}
	<br>
	{{ Form::label('password','Enter your password')}}
	{{ Form::password('password',array('class'=>'form-control')) }}
	<br>
	{{ Form::submit('Login',array('class'=>'btn btn-default')) }}
	{{ Form::close() }}
	</div>
</div>
@stop