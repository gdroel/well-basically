@extends('layout')


@section('content')

@if(Auth::check())
<div class="col-md-6 col-md-offset-3 movedown">
	<h2>Leave Feedback</h2>
	<hr>
	{{ Form::open(array('action'=>'HomeController@doFeedback')) }}
	{{ Form::text('subject',null, array('class'=>'form-control','placeholder'=>'Subject')) }}
	<br>
	{{ Form::textarea('body',null,array('class'=>'form-control','placeholder'=>'Body')) }}
	<br>
	{{ Form::submit('Send Feedback',array('class'=>'btn btn-default')) }}
</div>
@endif

@stop