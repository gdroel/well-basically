<!DOCTYPE html>
<html>

<head>
<style type="text/css">

</style>
    <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
<link rel="stylesheet" href="../css/style.css">
<link href='http://fonts.googleapis.com/css?family=Lato:400,700' rel='stylesheet' type='text/css'>

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script type="text/javascript"
  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBoaSu9IZTRrCkY1tTnMibgHg-uwB8aduk">
</script>


<script type="text/javascript">
var map = null;
var gmarkers = [];
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

  var td = document.getElementById("click");
  google.maps.event.addListener(td,'click',function(){

    var lat = td.getAttribute('data-lat');
    var lng = td.getAttribute('data-lng');

    var centerLatLng = new google.maps.LatLng(lat,lng);
    map.setCenter(centerLatLng);

  });
}



function setMarkers(map, locations) {

google.maps.event.addListener(map,'bounds_changed',function(){

  ul = document.getElementById('marker_list');
  ul.innerHTML = '';

});
 var infowindow = new google.maps.InfoWindow();
 var text = '';
 var marker = null;

  for (var i = 0; i < locations.length; i++) {

    var well = locations[i];
    var myLatLng = new google.maps.LatLng(well['lat'], well['lng']);
    var marker = new google.maps.Marker({
        position: myLatLng,
        map: map,
        title: well['address'],
        zIndex: well[3]
    });

  google.maps.event.addListener(map, 'bounds_changed', (function(marker){

    var ul = document.getElementById("marker_list");
    ul.innerHTML = '';
    return function(){

      if(map.getBounds().contains(marker.getPosition())){

        var li = document.createElement("li");
        var title = marker.getTitle();
        li.innerHTML = title;
        ul.appendChild(li);
        
        //Trigger a click event to marker when the button is clicked.
        google.maps.event.addDomListener(li, "click", function(){
          google.maps.event.trigger(marker, "click");
        });
      }

      else{

        ul.innerHTML = '';
      }

    }
    })(marker));


    
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
}

for(var i=0;i < locations.length; i++){


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

<div class="col-md-3 movedown75">
  <table class="table" id="text">
  </table>
  <ul id="marker_list">

  </ul>
</div>
 </body>
</html>