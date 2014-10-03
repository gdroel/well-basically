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
	@if(Auth::check())
		{{ Form::open(array('action'=>'HomeController@comment')) }}
		{{ Form::text('body',null,array('class'=>'form-control')) }}
		{{ Form::hidden('user_id', Auth::user()->id) }}
		{{ Form::hidden('address_id',$well->id) }}
		{{ Form::submit('Add Comment') }}
		{{ Form::close() }}
	@endif

	@foreach($well->comments as $comment)

	<p>{{ $comment->body }}</p>
	@endforeach
	</div>
	<div class="col-md-6 ">
	<div id="mini-map-canvas"></div>
	</div>
</div>
@stop