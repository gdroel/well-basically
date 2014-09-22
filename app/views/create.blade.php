@extends('layout')

@section('content')
<div class="container">
<div class="col-md-4 col-md-offset-4 movedown">
<h1>Add a Well</h1>
{{ Form::open(array('action'=>'HomeController@doCreate')) }}

{{ Form::label('address','Address')}}
{{ Form::text('address',null, array('class'=>'form-control')) }}
<br>
{{ Form::label('flow_rate','Flow Rate')}}
<div class="input-group">
{{ Form::text('flow_rate',null, array('class'=>'form-control')) }}
    <span class="input-group-addon">
        Gallons/Min
    </span>
 </div>
<br>

{{ Form::label('depth','Depth')}}
<div class="input-group">
{{ Form::text('depth',null, array('class'=>'form-control')) }}
    <span class="input-group-addon">
        Feet
    </span>
 </div>
<br>

{{ Form::label('year_dug','Year Drilled') }}
{{ Form::text('year_dug',null,array('class'=>'form-control')) }}
{{ Form::submit('Add Well',array('class'=>'btn btn-info')) }}
{{ Form::close() }}
</div>
</div>
@stop