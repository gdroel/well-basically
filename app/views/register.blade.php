@extends('layout')

@section('content')

<div class="col-md-4 col-md-offset-4 movedown">
<h2>Register</h2>
<hr>
@if($errors->has())
   @foreach ($errors->all() as $error)
      <div class="alert alert-danger" role="alert">{{ $error }}</div>
  @endforeach
@endif
{{ Form::open(array('action'=>'HomeController@doRegister'))}}
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