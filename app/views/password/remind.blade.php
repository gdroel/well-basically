@extends('layout')


@section('content')

<div class="col-md-4 col-md-offset-4 movedown">
<h2>Reset Password</h2>
<hr>
<form action="{{ action('RemindersController@postRemind') }}" method="POST">
    <input type="email" name="email" class="form-control" placeholder="Your Email">
    <br>
    <input type="submit" class="btn btn-info" value="Send Reminder">
</form>
</div>
@stop