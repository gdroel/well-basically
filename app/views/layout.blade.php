<!DOCTYPE html>
<html>

<head>
<title>Well Basically | The Well Database</title>
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
      <a class="navbar-brand" href="{{ action('HomeController@index') }}">Well Basically</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
      </ul>
        <div class="navbar-form navbar-right">
        <div class="form-group">
          <input id="pac-input" class="form-control search controls" type="text" placeholder="Search">
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

@yield('content')


<script type="text/javascript">
$(document).ready(function(){

  $("#pac-input").hide();
  $("#search").click(function(){

  $("#pac-input").toggle();
  $("#search").css({'margin-right':'0'});
  });

});
</script>
</body>
</html>