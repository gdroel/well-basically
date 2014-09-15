<!DOCTYPE html>
<html>

  <head>
    <style type="text/css">
      html, body, #map-canvas { height: 100%; margin: 0; padding: 0;}
    </style>
    <script type="text/javascript"
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBoaSu9IZTRrCkY1tTnMibgHg-uwB8aduk">
    </script>
    <script type="text/javascript">
function initialize() {
  var mapOptions = {
    zoom: 10,
    center: new google.maps.LatLng(35, -120)
  }
  var map = new google.maps.Map(document.getElementById('map-canvas'),
                                mapOptions);

  setMarkers(map, beaches);

    google.maps.event.addListener(marker, 'click', function() {
    map.setZoom(8);
    map.setCenter(marker.getPosition());
  });
}

/**
 * Data for the markers consisting of a name, a LatLng and a zIndex for
 * the order in which these markers should display on top of each
 * other.
 */
var beaches = <?php echo $addresses ?>

function setMarkers(map, locations) {

 var infowindow = new google.maps.InfoWindow();

  for (var i = 0; i < locations.length; i++) {
    var beach = locations[i];
    var myLatLng = new google.maps.LatLng(beach['lat'], beach['lng']);
    var marker = new google.maps.Marker({
        position: myLatLng,
        map: map,
        title: beach[0],
        zIndex: beach[3]
    });
    marker.address=beach['address'];

    //shows data when clicked
    google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
          infowindow.setContent(locations[i]['address']);
          infowindow.open(map, marker);
        }
      })(marker, i));

  }
}

google.maps.event.addDomListener(window, 'load', initialize);
    </script>
  </head>
  <body>
<div id="map-canvas"></div>
  </body>
</html>