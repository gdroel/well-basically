@extends('layout')

@section('content')
<script type="text/javascript">
var map = null;
var marker = null;
var gmarkers = [];

var wells = <?php echo $addresses ?>;
function initialize() {
var placesArray = [];
  var mapOptions = {
    zoom: 10,
    center: new google.maps.LatLng(35, -121)
  }

  var map = new google.maps.Map(document.getElementById('map-canvas'),
                              mapOptions);

    // Create the search box and link it to the UI element.
  var input = /** @type {HTMLInputElement} */(
      document.getElementById('pac-input'));
  //map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

  var searchBox = new google.maps.places.SearchBox(
    /** @type {HTMLInputElement} */(input));

  google.maps.event.addListener(searchBox, 'places_changed', function() {
      var places = searchBox.getPlaces();

      if (places.length == 0) {
        return;
      }
      // For each place, get the icon, place name, and location.
      var bounds = new google.maps.LatLngBounds();
      for (var i = 0, place; place = places[i]; i++) {

        placesArray.push(marker);

        bounds.extend(place.geometry.location);
        
      }

      map.fitBounds(bounds);
      map.setZoom(15);
    });

  google.maps.event.addListener(map, 'bounds_changed', function(){setMarkers(map, wells)});

}


function myclick(i) {
  google.maps.event.trigger(gmarkers[i], "click");
}


function setMarkers(map, locations) {
  var side_bar_html = '';
  side_bar_html = document.getElementById('text');
  side_bar_html.innerHTML = '';
  var infowindow = new google.maps.InfoWindow();
  
  for (var i = 0; i < locations.length; i++) {

    var well = locations[i];

    var myLatLng = new google.maps.LatLng(well['lat'], well['lng']);
    var marker = new google.maps.Marker({
        position: myLatLng,
        map: map,
        title: well['address']
    });

    if(map.getBounds().contains(marker.getPosition()) ){

      gmarkers.push(marker);

      side_bar_html.innerHTML += '<li class=\'list-group-item\' onClick="javascript:myclick(' + (gmarkers.length-1) + ')">' + well['address'] + '</li>';

    }

    google.maps.event.addListener(map,'click',function(){

      infowindow.close();
    });

    //shows data when clicked
    google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
          infowindow.setContent(
            '<p>'+locations[i]['address']+
            '<br>'+
            ' Flow Rate: '+
            locations[i]['flow_rate']+' gallons/min'+
            '<br>'+
            'Depth: '+
            locations[i]['depth']+' ft'+
            '<br> Drilled in: '+
            locations[i]['year_dug']+
            '<br> Post Updated On: '+
            well['update_at']+'</p>'

            );
          infowindow.open(map, marker);
          map.setCenter(marker.getPosition());
        }
      })(marker, i));
}

}


google.maps.event.addDomListener(window, 'load', initialize);
</script>
<div class="modal fade" id="wellModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h3 class="modal-title" id="myModalLabel">My Well</h3>
      </div>
      <div class="modal-body">
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
      </div>
      <div class="modal-footer">
      @if(!isset($well))
      {{ Form::submit('Add Well',array('class'=>'btn btn-info')) }}
      @else
      {{ Form::hidden('well_id',$well->id) }}
      {{ Form::submit('Edit Your Well',array('class'=>'btn btn-info')) }}
      @endif

      {{ Form::close() }}
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h3 class="modal-title" id="myModalLabel">Login</h3>
      </div>
      <div class="modal-body">
      {{ Form::open(array('action'=>'HomeController@doLogin'))}}
      {{ Form::label('email','Enter your Email Address')}}
      {{ Form::text('email',null,array('class'=>'form-control')) }}
      <br>
      {{ Form::label('password','Enter your password')}}
      {{ Form::password('password',array('class'=>'form-control')) }}
      

      </div>
      <div class="modal-footer">
      {{ Form::submit('Login',array('class'=>'btn btn-info')) }}
      {{ Form::close() }}
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h3 class="modal-title" id="myModalLabel">Register</h3>
      </div>
      <div class="modal-body">
      @if($errors->has())
       @foreach ($errors->all() as $error)
          <div>{{ $error }}</div>
      @endforeach
      @endif
      {{ Form::open(array('action'=>'HomeController@doRegister','id'=>'registerForm'))}}
      {{ Form::label('email','Enter your Email Address')}}
      {{ Form::text('email',null,array('class'=>'form-control')) }}
      <br>
      {{ Form::label('username','Choose a Username')}}
      {{ Form::text('username',null,array('class'=>'form-control')) }}
      <br>
      {{ Form::label('password','Choose a password')}}
      {{ Form::password('password',array('class'=>'form-control')) }}
      <br>
      </div>
      <div class="modal-footer">
      {{ Form::submit('Register',array('class'=>'btn btn-info')) }}
      {{ Form::close() }}
      </div>
    </div>
  </div>
</div>
<div class="col-md-9" id="i">
  <div id="map-canvas"></div>
</div>
<div class="col-md-3 movedown70">
<ul class="list-group" id="text">
</ul>
</div>
<style>
$(document).ready(function(){
$("#registerForm").validate({

  rules: {
  password: {
  required: true,
  minlength: 5
  },
  username: {
  required: true,
  minlength: 5,
  equalTo: "#password"
  },
  email: {
  required: true,
  email: true
  },
  topic: {
  required: "#newsletter:checked",
  minlength: 2
  },
  agree: "required"
  },
  messages: {
  username: "Please enter your firstname",
  lastname: "Please enter your lastname",
  username: {
  required: "Please enter a username",
  minlength: "Your username must consist of at least 2 characters"
  },
  password: {
  required: "Please provide a password",
  minlength: "Your password must be at least 5 characters long"
  },
  confirm_password: {
  required: "Please provide a password",
  minlength: "Your password must be at least 5 characters long",
  equalTo: "Please enter the same password as above"
  },
  email: "Please enter a valid email address",
  agree: "Please accept our policy"
  }
  });
});

</style>
@stop