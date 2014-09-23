<!DOCTYPE html>
<html>

<head>
<style type="text/css">

</style>
    <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
<link rel="stylesheet" href="../css/style.css">
<link href='http://fonts.googleapis.com/css?family=Lato:400,700' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Nobile:400,700' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>

<!-- Latest compiled and minified JavaScript -->
<script type="text/javascript"
  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBoaSu9IZTRrCkY1tTnMibgHg-uwB8aduk">
</script>
 <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places"></script>

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
      map.setZoom(8);
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

      side_bar_html.innerHTML += '<a class=\'list-group-item\' href="javascript:myclick(' + (gmarkers.length-1) + ')">' + well['address'] + '<\/a>';

    }
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
            locations[i]['updated_at']+'</p>'

          	);
          infowindow.open(map, marker);
          map.setCenter(marker.getPosition());
        }
      })(marker, i));
}

}


google.maps.event.addDomListener(window, 'load', initialize);
    </script>
  </head>
<body>
<nav class="navbar navbar-fixed-top" role="navigation">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Well Basically</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
      </ul>
        <div class="navbar-form navbar-right">
        <div class="form-group">
          <input id="pac-input" class="form-control controls" type="text" placeholder="Search Box">
        </div>
      </div>
      <ul class="nav navbar-nav navbar-right">
        @if(Auth::check())
        <li><a href="{{ action('HomeController@showCreate') }}">My Well</a></li>
        @else
        <li><a href="{{ action('HomeController@showLogin') }}">Login</a></li>
        <li><a href="{{ action('HomeController@showRegister') }}">Register</a></li>
        @endif
        <li><a id="search"><span  class="glyphicon glyphicon-search"></span></a></li>
      </ul>

    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
<div class="col-md-9" id="i">
  <div id="map-canvas"></div>
</div>
<div class="col-md-3 movedown75">
<ul class="list-group" id="text">
</ul>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

<script type="text/javascript">
$(document).ready(function(){

  $("#pac-input").hide();
  $("#search").click(function(){

    $("#pac-input").show();
 $("#search").css({'margin-right':'0'});
  });

});
</script>
 </body>
</html>