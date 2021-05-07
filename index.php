<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Login</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="components/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="components/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="components/css/vendor.bundle.addons.css">
  <!-- plugin css for this page -->
  <link rel="stylesheet" href="components/font-awesome/css/font-awesome.css">
  <!-- inject:css -->
  <link rel="stylesheet" href="css/style.css">
  <link rel="shortcut icon" href="images/innoland.png" /> 
</head>
<body background="images/login.jpg">
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper auth-page">
      <div class="content-wrapper d-flex align-items-center auth auth-bg-1 theme-one">
        <div class="row w-100">
          <div class="col-lg-4 mx-auto">
            <div class="auto-form-wrapper">
              <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
                <img src="images/AMS-TE.png" alt="logo" style="width:50%; height:30%"/>
              </div><br>
              <form action="#">
                <div class="form-group">
                  <label class="label">Username</label>
                  <div class="input-group">
                    <input id="uname" type="text" class="form-control" placeholder="Username">
                    <div class="input-group-append">
                      <span class="input-group-text fa fa-user menu-icon" style="color:#1e7bcb"></span>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="label">Password</label>
                  <div class="input-group">
                    <input id="pword" type="password" class="form-control" placeholder="*********">
                    <div class="input-group-append">
                      <span class="input-group-text fa fa-lock menu-icon" style="color:#1e7bcb"></span>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <button id="btnlogin" class="btn btn-primary submit-btn btn-block">Login</button>
                </div>
                <div id="warning" class="alert alert-danger" role="alert">
                  <center><i class="fa fa-warning menu-icon"></i> Invalid username or password. Please try again.</center>
                </div>
              </form>
            </div>
            <p class="footer-text text-center">copyright © 2019 Innoland Development Corporation. <br>All rights reserved.</p>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
    <!-- jquery -->
  <script src="components/jquery/jquery-3.4.1.min.js"></script>
  <!-- plugins:js -->
  <script src="components/js/vendor.bundle.base.js"></script>
  <script src="components/js/vendor.bundle.addons.js"></script>
  <!-- endinject -->
  <!-- inject:js -->
  <script src="js/off-canvas.js"></script>
  <script src="js/misc.js"></script>
  <!-- endinject -->
<script>
$('.alert').hide();
$('#pword').keyup(function(event){
  if(event.keycode === 13)
  {
    $('btnlogin').click
  }
});

$('#btnlogin').click(function(e){
  e.preventDefault();
  var uname = $('#uname').val();
  var pword = $('#pword').val();
  var myData = 'uname=' + uname + '&pword=' + pword;

  if(uname != "" && pword != "")
  {
    $.ajax({
      type: "POST",
      url: "controls/login.php",
      data: myData,

      success: function(response)
      {
        if(response > 0)
        {
          window.location = "controls/checkaccess.php";
        }
        else
        {
          $('#warning').show().fadeOut(5000);
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
</script>
</body>
</html>