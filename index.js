$('.alert').hide();
$('#pword').keyup(function(event){
  if(event.keycode === 13)
  {
    $('btnlogin').click
  }
});

$('#btnlogin').click(function(e){
  e.preventDefault();
  var username = $('#uname').val();
  var password = $('#pword').val();
  var myData = 'username=' + username + '&password=' + password;

  if(username != "" && password != "")
  {
    $.ajax({
      type: "POST",
      url: "controls/login.php",
      data: myData,
      success: function(response)
      {
        if(response > 0)
        {
            $.ajax({
                url: 'controls/checkaccess.php',
                success: function(response){
                    if(response > 0){
                        window.location = "controls/check_role.php";
                    }else{
                        $('#warning').show().fadeOut(5000);
                        $('.error-msg').html('<i class="fa fa-warning menu-icon"></i> ERROR! Login failed. Account is not yet activated. Please contact the administrator.');
                    }
                }
            })
        }
        else
        {
            $('#warning').show();
            $('.error-msg').html('<i class="fa fa-warning menu-icon"></i> ERROR! Incorrect Username or Password.');
            setTimeout(function () {
                $('#warning').fadeOut();
            }, 3000);
        }
      },
      error: function(xhr, ajaxOptions, thrownError)
      {
        alert(thrownError);
      }
    });
  }
  else
  {
    $('#warning').html("<center>ERROR!! All fields are required.</center>");
    $('#warning').show().fadeOut(5000);
  }
});