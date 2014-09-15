{{ Form::open(array('action'=>'HomeController@doCreate')) }}
{{ Form::text('address') }}
{{ Form::submit() }}
{{ Form::close() }}