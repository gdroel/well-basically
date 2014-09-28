@extends('layout')


@section('content')

<div class="col-md-4 col-md-offset-4 movedown">
<h2>Reset Password</h2>
<form action="{{ action('RemindersController@postRemind') }}" method="POST">
	<label for="email">Enter Your Email</label>
    <input type="email" name="email" class="form-control">
    <input type="submit" value="Send Reminder">
</form>
</div>
@stop