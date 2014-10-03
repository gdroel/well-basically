@extends('layout')

@section('content')

<script type="text/javascript">
var map = null;
var marker = null;
var gmarkers = [];
var allmarkers = [];

var wells = <?php echo $addresses ?>;

function initialize() {
var placesArray = [];
  var mapOptions = {
    zoom: 10,
    center: new google.maps.LatLng(35, -121),
    mapTypeControl: false,
    streetViewControl: false,
    mapTypeId: google.maps.MapTypeId.ROADMAP
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
var allmarkers = [];
  var image = {
    url: 'images/bluemarker.png',
    // This marker is 20 pixels wide by 32 pixels tall.
    size: new google.maps.Size(20, 32),
    // The origin for this image is 0,0.
    origin: new google.maps.Point(0,0),
    // The anchor for this image is the base of the flagpole at 0,32.
    anchor: new google.maps.Point(0, 32)
  };
  // Shapes define the clickable region of the icon.
  // The type defines an HTML &lt;area&gt; element 'poly' which
  // traces out a polygon as a series of X,Y points. The final
  // coordinate closes the poly by connecting to the first
  // coordinate.
  var shape = {
      coords: [1, 1, 1, 20, 18, 20, 18 , 1],
      type: 'poly'
  };
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
        title: well['address'],
        icon: image,
        shape: shape
    });

    allmarkers.push(marker);

     if(map.getBounds().contains(marker.getPosition()) ){


      gmarkers.push(marker);

      side_bar_html.innerHTML += '<li class=\'list-group-item\' onClick="javascript:myclick(' + (gmarkers.length-1) + ')">' + well['address'] + '</li>';

    }

    google.maps.event.addListener(map,'click',function(){

      infowindow.close();
    });


    var t = well['updated_at'].split(/[- :]/);
    var d = new Date(t[0], t[1]-1, t[2], t[3], t[4], t[5]);

    var date = (d.getMonth() + 1) + "/" + d.getDate() + "/" + d.getFullYear();
    //shows data when clicked
    google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
          infowindow.close();
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
            date+'</p>'
            );
          infowindow.open(map, marker);
          map.setCenter(marker.getPosition());
        }
      })(marker, i,infowindow));
}

  var markerClusterer = new MarkerClusterer(map, allmarkers);

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
      <div class="login-errors">
      </div>
      {{ Form::open(array('action'=>'HomeController@doLogin','method'=>'POST','id'=>'login'))}}
      {{ Form::label('email','Enter your Email Address')}}
      {{ Form::text('email',null,array('class'=>'form-control')) }}
      <br>
      {{ Form::label('password','Enter your password')}}
      {{ Form::password('password',array('class'=>'form-control')) }}

      </div>
      <div class="modal-footer">
      <small class="pull-left"><a href="{{ action('RemindersController@getRemind') }}">Forgot Password?</a></small>
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
<div class="col-sm-9" id="i">
  <div id="map-canvas"></div>
</div>
<div class="col-sm-3 movedown70 scroll">
@if (Session::has('message'))
<div class="alert alert-success alert-dismissible message"  id="success-alert" role="alert">
  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
  {{ Session::get('message') }}
</div>
@endif
<ul class="list-group" id="text">
</ul>

</div>

<script type="text/javascript">
$(document).ready(function(){

$("#pac-input").hide();
$(window).resize(function(){
  if($(window).width() <= 640){

      $("#pac-input").show();
      $("#search").hide();

  }

  else{

      $('#search').show();


  }

});

$("#search").click(function(){
  $("#pac-input").toggle();
});

$("#success-alert").alert();
$("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
$("#success-alert").alert('close');
});
/*
  //AJAX Login
  $('form#login').submit(function()
  {
    
    $.ajax({
      url: "<?php echo URL::route('login');?>",
      type: "post",
      data: $('form#login').serialize(),
      datatype: "json",
      beforeSend: function()
      {
        $('#ajax-loading').show();
        $(".validation-error-inline").hide();
      }
      })
      .done(function(data)
      {
        $('.login-errors').empty();
        if (data.login_failed == 1)
        {

          $('.login-errors').append('<div class="alert alert-danger" role="alert">Invalid Username or Password</span></label>');
        }
        else{

        if(data.validation_failed != 1){

          $('#loginModal').modal('hide');
          $('#register-link').remove();
          $('#login-link').remove();
          $('#nav-links').prepend("<li><a href="+"'<?php echo URL::to('logout');?>'"+">Logout</a></li>");
          $('#nav-links').prepend('<li><a data-toggle="modal" data-target="#wellModal">My Well</a></li>');
        }
        }
        if (data.validation_failed == 1)
        {
          var arr = data.errors;
          $.each(arr, function(index, value)
          {
            if (value.length != 0)
            {
              $('.login-errors').append('<div class="alert alert-danger" role="alert">' + value + '</div>');
            }
          });
          $('#ajax-loading').hide();
        }
      })
      .fail(function()
      {
          alert('No response from server');
      });
      return false;
  });

*/

});
</script>
<script>
</script>
@stop