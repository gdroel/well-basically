@extends('layout')


@section('content')
<div class="col-md-4 col-md-offset-4 movedown">
<h2>Set a New Password</h2>
<hr>
<form action="{{ action('RemindersController@postReset') }}" method="POST">
    <input type="hidden" class="form-control" name="token" value="{{ $token }}">
    <label for="email">Confirm Your Email Address</label>
    <input type="email" class="form-control" name="email">
    <br>
    <label for="password">Set a New Password</label>
    <input type="password" class="form-control" name="password">
    <br>
    <label for="password_confirmation">Confirm your Password</label>
    <input type="password" class="form-control" name="password_confirmation">
    <br>
    <input type="submit" class="btn btn-info" value="Reset Password">
</form>
</div>
@stop