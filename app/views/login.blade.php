@extends('layout')

@section('content')

<div class="col-md-4 col-md-offset-4 movedown">
<h1>Login</h1>
<br>
{{ Form::open(array('action'=>'HomeController@doLogin'))}}
<br>
{{ Form::label('email','Enter your Email Address')}}
{{ Form::text('email',null,array('class'=>'form-control')) }}
<br>
{{ Form::label('password','Enter your password')}}
{{ Form::password('password',array('class'=>'form-control')) }}
<br>
{{ Form::submit('Login',array('class'=>'btn btn-info')) }}
{{ Form::close() }}
</div>
@stop