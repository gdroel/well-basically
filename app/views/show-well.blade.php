@extends('layout')

@section('content')
<script>
var json_array = '<?php echo json_encode($well) ?>';

var well = JSON.parse(json_array);

function initialize() {
  var myLatlng = new google.maps.LatLng(well.lat,well.lng);
  var mapOptions = {
    zoom: 4,
    center: myLatlng
  }
  var map = new google.maps.Map(document.getElementById('mini-map-canvas'), mapOptions);

  var marker = new google.maps.Marker({
      position: myLatlng,
      map: map,
      title: well.address
  });
}

google.maps.event.addDomListener(window, 'load', initialize);
</script>
<div class="container-fluid movedown70">
	<div class="col-md-6">
	<br>
	<p class="gray">{{ Str::upper($well->address) }}</p>
	
	<table class="table">
		<tr>
			<td>Year Dug</td>
			<td>{{ $well->year_dug }}</td>
		</tr>
		<tr>
			<td>Flow Rate</td>
			<td>{{ $well->flow_rate }}</td>
		</tr>
		<tr>
			<td>Depth</td>
			<td>{{ $well->depth }}</td>
		</tr>

	</table>
	<hr>
	@if(Auth::check())
	<h4>Leave a Comment</h4>
		{{ Form::open(array('action'=>'HomeController@comment')) }}
		{{ Form::textarea('body',null,array('class'=>'form-control comment-textarea','rows'=>4)) }}
		{{ Form::hidden('user_id', Auth::user()->id) }}
		{{ Form::hidden('address_id',$well->id) }}
		<br>
		{{ Form::submit('Add Comment',array('class'=>'btn btn-default')) }} 
		<p class="inline gray pull-right">  You are logged in as {{ Auth::user()->username }} </p>
		{{ Form::close() }}
	@endif

	@foreach($well->comments as $comment)
	<div class="comment">
	<p class="gray">{{ $comment->user->username }}</p>
	<p>{{ $comment->body }}</p>
	</div>
	@endforeach
	</div>
	<div class="col-md-6 ">
	<div id="mini-map-canvas"></div>
	</div>
</div>
@stop