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
		{{ Form::hidden('comment_parent',0)}}
		<br>
		{{ Form::submit('Add Comment',array('class'=>'btn btn-default')) }} 
		<p class="inline gray pull-right">  You are logged in as {{ Auth::user()->username }} </p>
		{{ Form::close() }}
	@endif

	@foreach($well->comments as $comment)
		<div class="comment">
			<p class="gray">{{ $comment->user->username }}</p>
			<p>{{ $comment->body }}</p>
			<a class="reply-button">Reply</a>
		</div>
		
		{{ Form::open(array('action'=>'HomeController@comment','class'=>'form-reply')) }}
		{{ Form::textarea('body',null,array('class'=>'form-control comment-textarea','rows'=>2)) }}
		{{ Form::hidden('user_id', Auth::user()->id) }}
		{{ Form::hidden('address_id',$well->id) }}
		{{ Form::hidden('comment_parent',$comment->id) }}
		<br>
		{{ Form::submit('Add Comment',array('class'=>'btn btn-default')) }} 
		{{ Form::close() }}
		@foreach($comment->replies as $reply)
			<div class="comment" style="margin-left:15px">
				<p>{{$reply->body }}</p>
			</div>
		@endforeach
	@endforeach
	</div>
	<div class="col-md-6 ">
	<div id="mini-map-canvas"></div>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
$('.form-reply').hide();
    $('.reply-button').click(function(){
        $(this).parent().next('.form-reply').show();
    });

})
</script>
@stop