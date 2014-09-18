<!DOCTYPE html>
<html>

<head>
<style type="text/css">

</style>
    <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
<link rel="stylesheet" href="../css/style.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script type="text/javascript"
  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBoaSu9IZTRrCkY1tTnMibgHg-uwB8aduk">
</script>



<script type="text/javascript">
var map = null;
var wells = <?php echo $addresses ?>;
function initialize() {
  var mapOptions = {
    zoom: 10,
    center: new google.maps.LatLng(35, -121)
  }

  var map = new google.maps.Map(document.getElementById('map-canvas'),
                              mapOptions);

  setMarkers(map, wells);

    google.maps.event.addListener(marker, 'click', function() {
    map.setZoom(8);
    map.setCenter(marker.getPosition());
  });

}



function setMarkers(map, locations) {

 var infowindow = new google.maps.InfoWindow();
 var text = '';
  for (var i = 0; i < locations.length; i++) {
    var well = locations[i];
    var myLatLng = new google.maps.LatLng(well['lat'], well['lng']);
    var marker = new google.maps.Marker({
        position: myLatLng,
        map: map,
        title: well[0],
        zIndex: well[3]
    });


    
    //shows data when clicked
    google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
          infowindow.setContent(
          	locations[i]['address']+
          	'<br>'+
          	' Flow Rate: '+
          	locations[i]['flow_rate']+' gallons/min'+
          	'<br>'+
          	'Depth: '+
          	locations[i]['depth']+' ft'+
          	'<br>'

          	);
          infowindow.open(map, marker);
          map.setCenter(marker.getPosition());
        }
      })(marker, i));

     google.maps.event.addListener(map, 'bounds_changed', function() {

        if (map.getBounds().contains(myLatLng) ){

        text = well['address'];
        document.getElementById("text").innerHTML = text;
        
        } else {
        
        document.getElementById("text").innerHTML += text;
        text = '';
        }
      
    });
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
        <li class="active"><a href="#">Link</a></li>
        <li><a href="#">Link</a></li>
      </ul>
      <form class="navbar-form navbar-left" role="search">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Search">
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
      </form>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="{{ action('HomeController@showCreate') }}">Add a Well</a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
<div class="col-md-9" id="i">
<div id="map-canvas"></div>
</div>

<div class="col-md-3 movedownless">
  <h2>Wells Nearby</h2>
  <div id="text">
  </div>
</div>
 </body>
</html>