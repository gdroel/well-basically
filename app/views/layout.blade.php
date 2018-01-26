<!DOCTYPE html>
<html>

<head>
<title>Wellsio || The Crowdsourced Well Database</title>
    <!-- Latest compiled and minified CSS -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="Wellsio.com is a crowdsourced, comprehensive water wells database. It's like Zillow, but for wells.">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
<link rel="stylesheet" href="../../css/style.css">
<link href='http://fonts.googleapis.com/css?family=Lato:400,700' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Nobile:400,700' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
<script src="../js/markerclusterer.js"></script>

<!-- Latest compiled and minified JavaScript -->
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCXfReHSEFzgIcXyRiiEt6xynYheahal-s&callback=initMap"
  type="text/javascript"></script>
</script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCXfReHSEFzgIcXyRiiEt6xynYheahal-s&libraries=places"></script>
</head>
<body>
<nav class="navbar navbar-fixed-top"  role="navigation">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="{{ action('HomeController@index') }}">Wellsio</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
  
      </ul>
        @if(Request::is('/'))
        <div class="navbar-form navbar-right">
        <div class="form-group">
          <input id="pac-input" class="form-control search controls" type="text" placeholder="Where do you live?">
        </div>
        </div>
        @endif
      <ul class="nav navbar-nav navbar-right" id="nav-links">

          @if(Request::is('/'))
          <!-- <li><a id="mywell" href="{{ action('HomeController@showCreate') }}">My Well</a></li> -->
            @if(Auth::check())
            <li><a data-toggle="modal" data-target="#wellModal">My Well</a></li>
            <li><a href="{{ action('HomeController@doLogout') }}">Logout</a></li>
            <li><a id="search"><span  class="glyphicon glyphicon-search"></span></a></li>
            @else
            <li><a href="{{ URL::to('about') }}">About</a></li>
            <li><a data-toggle="modal" data-target="#loginModal" id="login-link">Login</a></li>
            <li><a data-toggle="modal" data-target="#registerModal" id="register-link">Register</a></li>
            <li><a id="search"><span  class="glyphicon glyphicon-search"></span></a></li>
            @endif
        

          @else

            @if(Auth::check())
            <li><a href="{{ action('HomeController@showCreate') }}">My Well</a></li>
            <li><a href="{{ action('HomeController@doLogout') }}">Logout</a></li>
            @else
            <li><a href="{{ URL::to('about') }}">About</a></li>
            <li><a href="{{ action('HomeController@showLogin') }}"id="login-link">Login</a></li>
            <li><a href="{{ action('HomeController@showRegister') }}" id="register-link">Register</a></li>
            @endif
          
          @endif
    
      </ul>

    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
@yield('content')
@if(!Request::is('/') || Request::is('about'))
<div class="navbar-fixed-bottom footer">
        <p class="navbar-text">&copy 2018 Wellsio</p>
        <p class="navbar-text"><a class="white" href="{{ action('HomeController@showFeedback') }}">Leave Feedback</a></p>
</div>
@endif
</body>
</html>