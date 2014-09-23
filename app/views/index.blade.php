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

      side_bar_html.innerHTML += '<li class=\'list-group-item\' onClick="javascript:myclick(' + (gmarkers.length-1) + ')">' + well['address'] + '</li>';

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
<div class="col-md-9" id="i">
  <div id="map-canvas"></div>
</div>
<div class="col-md-3 movedown70">
<ul class="list-group" id="text">
</ul>
</div>

@stop