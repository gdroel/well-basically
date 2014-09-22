@extends('layout')

@section('content')

<div class="col-md-4 col-md-offset-4 movedown">
<h1>Register</h1>
<br>
{{ Form::open(array('action'=>'HomeController@doRegister'))}}
<br>
{{ Form::label('email','Enter your Email Address')}}
{{ Form::text('email',null,array('class'=>'form-control')) }}
<br>
{{ Form::label('username','Choose a Username')}}
{{ Form::text('username',null,array('class'=>'form-control')) }}
<br>
{{ Form::label('password','Choose a password')}}
{{ Form::password('password',array('class'=>'form-control')) }}
<br>
{{ Form::submit('Register',array('class'=>'btn btn-info')) }}
{{ Form::close() }}
</div>
@stop