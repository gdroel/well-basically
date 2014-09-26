$(document).ready(function()
{

  //Search Bar
  $("#pac-input").hide();
  $("#search").click(function(){

  $("#pac-input").toggle();
  });

  //AJAX Login
  $('form#login').submit(function()
  {
    
    $.ajax({
      url: path, //Got this from index.blade.php page
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
          $('#nav-links').prepend("<li><a href="+logout_path+">Logout</a></li>");
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



});