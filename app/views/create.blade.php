@extends('layout')

@section('content')
<div class="container">
<div class="col-md-6 col-md-offset-3 movedown">
<h2>My Well</h2>
<hr>
@if($errors->has())
   @foreach ($errors->all() as $error)
      <div class="alert alert-danger" role="alert">{{ $error }}</div>
  @endforeach
@endif
@if(!isset($well))
{{ Form::open(array('action'=>'HomeController@doCreate')) }}
@else
{{ Form::open(array('action'=>'HomeController@doEdit')) }}
@endif
{{ Form::label('address','Address') }}

@if(isset($well))
{{ Form::text('address',$well->address, array('class'=>'form-control')) }}
@else
{{ Form::text('address',null, array('class'=>'form-control')) }}
@endif
<br>
{{ Form::label('flow_rate','Flow Rate')}}
<div class="input-group">
@if(isset($well))
{{ Form::text('flow_rate',$well->flow_rate, array('class'=>'form-control')) }}
@else
{{ Form::text('flow_rate',null, array('class'=>'form-control')) }}
@endif
    <span class="input-group-addon">
        Gallons/Min
    </span>
 </div>
<br>

{{ Form::label('depth','Depth')}}
<div class="input-group">
@if(isset($well))
{{ Form::text('depth',$well->depth, array('class'=>'form-control')) }}
@else
{{ Form::text('depth',null, array('class'=>'form-control')) }}
@endif
    <span class="input-group-addon">
        Feet
    </span>
 </div>
<br>

{{ Form::label('year_dug','Year Drilled') }}
@if(isset($well))
{{ Form::text('year_dug',$well->year_dug ,array('class'=>'form-control')) }}
@else
{{ Form::text('year_dug',null ,array('class'=>'form-control')) }}
@endif
<br>
@if(!isset($well))
{{ Form::submit('Add Well',array('class'=>'btn btn-info')) }}
@else
{{ Form::hidden('well_id',$well->id )}}
{{ Form::submit('Edit Your Well',array('class'=>'btn btn-info')) }}
@endif

{{ Form::close() }}
</div>
</div>
@stop