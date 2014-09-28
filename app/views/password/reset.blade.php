@extends('layout')


@section('content')
<div class="col-md-4 col-md-offset-4">
<form action="{{ action('RemindersController@postReset') }}" method="POST">
    <input type="hidden" class="form-control" name="token" value="{{ $token }}">
    <input type="email" name="email">
    <input type="password" name="password">
    <input type="password" name="password_confirmation">
    <input type="submit" value="Reset Password">
</form>
</div>
@stop