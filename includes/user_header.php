<?php
session_start();
  if($_SESSION['access_type'] != '3')
  {
    header('Location: ../../controls/logout.php');
  }

  $name = $_SESSION['fullname'];
  $user_id = $_SESSION['id'];

  include '../../config/clsConnection.php';
  include '../../objects/clsAsset.php';
  include '../../objects/clsLocation.php';
  include '../../objects/clsDepartment.php';
  include '../../objects/clsPersonnel.php';
  include '../../objects/clsUser.php';
  include '../../objects/clsType.php';
  include '../../objects/clsRecord.php';

  $database = new clsConnection();
  $db = $database->connect();

  $asset = new Asset($db);
  $loc = new Location($db);
  $dept = new Department($db);
  $person = new Personnel($db);
  $user = new Users($db);
  $type = new Type($db);
  $record = new TransferRecord($db);
?>
<nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
  <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
    <a class="navbar-brand" href="home.php">
      <img src="../../images/AMS-TE.png" alt="logo" style="height: 50px" />
    </a>
  </div>
  <div class="navbar-menu-wrapper d-flex align-items-center">
    <ul class="navbar-nav navbar-nav-left header-links d-none d-md-flex">
      <li class="nav-item">
        <a class="nav-link" href="home.php">
          <i class="menu-icon fa fa-barcode"></i>
          <span class="menu-title">Asset List</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="personnel.php">
          <i class="menu-icon fa fa-users"></i>
          <span class="menu-title">Assignee</span>
        </a>
      </li>
    </ul>
    <ul class="navbar-nav navbar-nav-right">
      <li class="nav-item dropdown d-none d-xl-inline-block">
        <a class="nav-link dropdown-toggle" id="UserDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
          <span class="profile-text">Hello, <?php echo $name;?></span>
        </a>
        <div class="dropdown-menu navbar-dropdown" aria-labelledby="UserDropdown">
          <a class="dropdown-item p-0">
            <a href="" class="dropdown-item mt-2" data-toggle="modal" data-target="#accountModal" id="settings"><i class="menu-icon fa fa-cogs"></i>Manage Accounts</a>
            <a href="../../controls/logout.php" class="dropdown-item"><i class="menu-icon fa fa-sign-out"></i>Sign Out</a>
          </a>
        </div>
      </li>
    </ul>
    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
      <span class="mdi mdi-menu"></span>
    </button>
  </div>
</nav>

<!-- Account Settings MODAL -->
<div class="modal fade" id="accountModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><span class="fa fa-cogs"></span> Account Settings</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <div class="row">
              <div class="col-lg-6">
                <label for="exampleInputEmail1">Firstname</label>
                <input type="text" class="form-control" id="acc_fname" placeholder="Enter Firstname" value="<?php echo $_SESSION['firstname']; ?>">
                 <input type="text" class="form-control" id="acc_id" placeholder="Enter Firstname" value="<?php echo $_SESSION['id']; ?>" hidden>
              </div>
              <div class="col-lg-6">
                <label for="exampleInputEmail1">Lastname</label>
                <input type="text" class="form-control" id="acc_lname" placeholder="Enter Lastname" value="<?php echo $_SESSION['lastname']; ?>">
              </div>
            </div><br>
            <div class="row">
              <div class="col-lg-6">
                <label for="exampleInputEmail1">Username</label>
                <input type="text" class="form-control" id="acc_username" placeholder="Enter Firstname" value="<?php echo $_SESSION['username']; ?>" disabled>
              </div>
              <div class="col-lg-6">
                <input type="text" class="form-control" id="acc_role" placeholder="Enter Firstname" value="<?php echo $_SESSION['access_type']; ?>" hidden>
              </div>
            </div><br>
            <div class="row">
              <div class="col-lg-6">
                <label for="exampleInputEmail1">Password</label>
                <input type="password" class="form-control" id="acc_password" placeholder="Enter Password">
              </div>
              <div class="col-lg-6">
                <label for="exampleInputEmail1">Confirm Password</label>
                <input type="password" class="form-control" id="acc_password2" placeholder="Confirm Password">
              </div>
            </div>
             <div class="row">
              <div class="col-lg-12">
                <span style="color:red; font-size:13px">NOTE: Leave the password blank if you dont want to change it.</span>
              </div>
            </div>
          </div><!-- end of form-group -->
        <!-- ALERTS -->
        <span id="acc-alert" class="alert"></span>
        <div id="acc-warning" class="alert alert-danger" role="alert" style="display: none"></div>
        <div id="acc-success" class="alert alert-success" role="alert" style="display: none"></div>
      </div><!-- end of modal body -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button id="save_account" type="button" class="btn btn-primary">Save</button>
      </div>
    </div>
  </div>
</div>

<!-- modal after successful change of password -->
<div id="AccountnoticeModal" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><b>NOTICE</b></h4>
      </div>
      <div class="modal-body">
        <p>We notice that your password has changed. You need to login again to complete the process <a href="../../controls/logout.php"><b><u>Click here</b></u></a> to continue.</p>
      </div>
      <div class="modal-footer">
        <a class="btn btn-primary" href="../../controls/logout.php">Logout</a>
      </div>
    </div>
  </div>
</div> 

<!-- jquery -->
<script src="../../components/jquery/jquery-3.4.1.js"></script>

<!-- check if password match -->
<script>
$('#acc_password2').keyup(function(){
  var acc_newpass = $('#acc_password').val();
  var acc_repass = $(this).val();

  if(acc_newpass == acc_repass)
  {
    document.getElementById("acc-alert").innerHTML = "<label style='color:green'>Password match</label>";
    $('#save_account').attr('disabled', false);
  }
  else
  {
    document.getElementById("acc-alert").innerHTML = "<label style='color:red'>ERROR! Password not match</label>";
    $('#save_account').attr('disabled', true);
  }
})  
</script>

<!-- save updated account setting -->
<script>
$('#save_account').click(function(e){
  e.preventDefault();

  var id = $('#acc_id').val();
  var firstname = $('#acc_fname').val();
  var lastname = $('#acc_lname').val();
  var username = $('#acc_username').val();
  var access_type = $('#acc_role').val();
  var password = $('#acc_password').val();
  var password2 = $('#acc_password2').val();
  var myData = 'id=' + id + '&firstname=' + firstname + '&lastname=' + lastname + '&username=' + username + '&access_type=' + access_type + '&password=' + password;

  if(password2 != "" || password != "")
  {
    $.ajax({
      type: "POST",
      url: "../../controls/update_user.php",
      data: myData,

      success: function(response)
      {
        //alert(response);
        if(response > 0)
        {
          $('#acc-success').html("<center><i class='fa fa-check menu-icon></i> User Details Successfully updated.</center>");
          $('#acc-success').show().fadeOut(5000);
          $('#accountModal').hide();
          $('#AccountnoticeModal').modal({backdrop: 'static', keyboard: false});
        }
        else
        {
          $('#acc-warning').html("<center><i class='fa fa-warning menu-icon'></i> Update Failed. Please contact the system administrator for assistance.</center>");
          $('#acc-warning').show().fadeOut(5000);
          return false;
        }
      },
      error: function(xhr, ajaxOptions, thrownError)
      {
        alert(thrownError);
      }
    })
  }
})  
</script>

<!-- Auto Generated username base in input detials of user -->
<script>
$('#acc_lname').blur(function(e){
  e.preventDefault();

  var str = $('#acc_fname').val();
  var fname = str.replace(/\s/g,'');
  var f = fname.toLowerCase();
  var str1 = $('#acc_lname').val();
  var lname = str1.replace(/\s/g,'');
  var l = lname.toLowerCase();
  var username = f.concat('.').concat(l);
  $('#acc_username').val(username);
})

$('#acc_fname').blur(function(e){
  e.preventDefault();

  var str = $('#acc_fname').val();
  var fname = str.replace(/\s/g,'');
  var f = fname.toLowerCase();
  var str1 = $('#acc_lname').val();
  var lname = str1.replace(/\s/g,'');
  var l = lname.toLowerCase();
  var username = f.concat('.').concat(l);
  $('#acc_username').val(username);
})
</script>