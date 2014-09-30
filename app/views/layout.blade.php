<!DOCTYPE html>
<html>

<head>
<title>Well Basically | The Well Database</title>
    <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
<link rel="stylesheet" href="../../css/style.css">
<link href='http://fonts.googleapis.com/css?family=Lato:400,700' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Nobile:400,700' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
<script src="../js/markerclusterer.js">

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

</body>
</html>