<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>AMS Tools + Equipment</title>
  <!-- DataTables -->
  <link rel="stylesheet" href="../../components/dataTables/css/dataTables.bootstrap.min.css">
  <!-- plugins:css -->
  <link rel="stylesheet" href="../../components/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="../../components/css/vendor.bundle.addons.css">
  <link rel="stylesheet" href="../../components/mdi/css/materialdesignicons.min.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../../css/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="../../images/innoland.png" /> 
  <!-- plugin css for this page -->
  <link rel="stylesheet" href="../../components/font-awesome/css/font-awesome.css">
  <!-- select2 plugin -->
  <link rel="stylesheet" href="../../components/select2/select2.min.css">
   <!-- date picker -->
  <link rel="stylesheet" type="text/css" href="../../components/datetimepicker/css/datepicker.min.css">
</head>

<body>
<div class="container-scroller">
  <!-- page navbar -->
  <?php 
  include '../../includes/tool_header.php';//include the header 
    if(!$_SESSION['username'])
    {
      header("Location: index.php");
    }
  ?>
  <input style="display:none" id="log_count" value="<?php echo $_SESSION['log_count']; ?>">
  <!-- main panel -->
    <div class="container-fluid page-body-wrapper">
        <div class="content-wrapper">
          <div class="row">
            <!-- Tool Details -->
            <div class="form-group col-lg-6">
              <div class="card">
                <div class="card-body">
                  <h5><span class="fa fa-database"></span> Tool & Equipment Details</h5><br>
                  <div class="row">
                    <div class="col-lg-8">
                      <label for="exampleInputEmail1" style="font-size: 16px">Tools & Equipment Code</label>&nbsp;<span style="color: red; font-size: 16px">*</span>
                      <input type="text" class="form-control" id="code" placeholder="Please scan the Code" required="required">
                    </div>
                  </div><br>
                  <div class="row">
                    <div class="col-lg-12">
                      <label for="exampleInputEmail1">Description</label>
                      <textarea type="text" class="form-control" id="description" rows="4" disabled></textarea>
                    </div>
                  </div><br>
                  <div class="row">
                    <div class="col-lg-6">
                      <label for="exampleInputEmail1">Brand</label>
                      <input type="text" class="form-control" id="brand" disabled>
                    </div>
                    <div class="col-lg-6">
                      <label for="exampleInputEmail1">Serial No.</label>
                      <input type="text" class="form-control" id="serial" disabled>
                    </div>
                  </div><br>
                  <div class="row">
                    <div class="col-lg-6">
                      <label for="exampleInputEmail1">Barcode</label>
                      <input type="text" class="form-control" id="barcode" disabled>
                    </div>
                    <div class="col-lg-6">
                      <label for="exampleInputEmail1">Model</label>
                      <input type="text" class="form-control" id="model" disabled>
                    </div>
                  </div>
                </div>
              </div>
            </div><!-- end of form-group -->
            <!-- Worker Details -->
            <div class="form-group col-lg-6">
              <div class="card">
                <div class="card-body">
                  <h5><span class="fa fa-id-card"></span> Borrower's Details</h5><br>
                  <div class="row">
                    <div class="col-lg-8">
                      <label for="exampleInputEmail1" style="font-size: 16px">Employee ID Code</label>&nbsp;<span style="color: red; font-size: 16px">*</span>
                      <input type="text" class="form-control" id="borrow-code" placeholder="Please scan the Code" required="required">
                    </div>
                  </div><br>
                  <div class="row">
                    <div class="col-lg-6">
                      <label for="exampleInputEmail1">Borrower Name</label>
                      <input type="text" class="form-control" id="fullname" disabled>
                    </div>
                    <div class="col-lg-6">
                      <label for="exampleInputEmail1">Trade</label>
                      <input type="text" class="form-control" id="trade" disabled>
                    </div>
                  </div><br>
                  <div class="row">
                    <div class="col-sm-6">
                      <label for="exampleInputEmail1">Date Borrowed</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text fa fa-calendar"></span>
                          </div>
                          <input type="text" class="form-control date-warranty" id="date_borrowed" disabled>
                        </div>
                    </div>
                     <div class="col-sm-6">
                      <label for="exampleInputEmail1">Date Returned</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text fa fa-calendar"></span>
                          </div>
                          <input type="text" class="form-control date-warranty" id="date_retruned"/>
                        </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-12">
                      <div id="asset-warning" class="alert alert-danger" role="alert" style="display: none"></div>
                    </div>
                  </div><br>
                  <div class="row">
                    <div class="col-lg-12">
                      <button id="save_asset" type="button" class="btn btn-primary pull-right">Submit</button>
                    </div>
                  </div>
                </div>
              </div>
            </div><!-- end of column -->
          </div><!-- end of row -->
    </div><!-- end of container-fluid -->
</div><!-- end of container-scroller -->

<!-- content-wrapper ends -->
<!-- partial:partials/_footer.html -->
<footer class="footer">
  <div class="container-fluid clearfix"><center>
    <span class="d-block text-center text-sm-left d-sm-inline-block">Copyright © 2019
      <a href="http://www.innogroup.com.ph/" target="_blank">Innoland Development Corporation</a>. All rights reserved.</span>
    </span></center>
  </div>
</footer>

<!-- MODALS SECTION -->
<!-- CHANGE PASSWORD MODAL IF LOGCOUNT = 0 -->
<div id="changepass" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><b>Account Settings</b></h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="alert alert-info" role="alert">
            <b>First Time to log-in? You must changed the default password to secure your account before you proceed.</b>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <label>Username:</label>
            <input type="text" class="form-control" value="<?php echo $_SESSION['username']; ?>" id="username" disabled>
            <input type="hidden" class="form-control" value="<?php echo $_SESSION['id']; ?>" id="id" disabled>
          </div>
        </div><br>
        <div class="row">
          <div class="col-sm-12">
            <label>Password</label>
            <input type="password" class="form-control" id="new_pass">
          </div>
        </div><br>
        <div class="row">
          <div class="col-sm-12">
            <label>Re-type Password:</label>
            <input type="password" class="form-control" id="re_pass">
          </div>
        </div><br>        
        <!-- alerts -->
        <div class="col-lg-12">
          <span id="pass_alert" class="alert"></span>
          <!--ALERTS-->
          <div class="alert alert-danger" id="error_msg" style="display:none"></div>
        </div>
      </div>
      <div class="modal-footer">
        <button id="later_pass" type="button" class="btn btn-secondary" data-dismiss="modal">Change Later</button>
        <button id="upd_pass" type="button" class="btn btn-success" disabled>Update</button>
      </div>
    </div>
  </div>
</div>

<!-- modal after successful change of password -->
<div id="noticeModal" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><b>NOTICE</b></h4>
      </div>
      <div class="modal-body">
        <p>Congratulation, your password has been successfully updated. You need to login again to complete the process <a href="../../controls/logout.php"><b><u>Click here</b></u></a> to continue.</p>
      </div>
      <div class="modal-footer">
        <a class="btn btn-primary" href="../../controls/logout.php">Logout</a>
      </div>
    </div>
  </div>
</div>
  
<!-- data tables -->
<script src="../../components/dataTables/js/jquery.dataTables.min.js"></script>

<!-- plugins:js -->
<script src="../../components/js/vendor.bundle.base.js"></script>
<script src="../../components/js/vendor.bundle.addons.js"></script>
<!-- endinject -->
<!-- Plugin js for this page-->
<!-- End plugin js for this page-->
<!-- inject:js -->
<script src="../../js/off-canvas.js"></script>
<script src="../../js/misc.js"></script>
<!-- endinject -->
<!-- Custom js for this page-->
<script src="../../js/dashboard.js"></script>
<!-- select2 plugin -->
<script src="../../components/select2/select2.min.js"></script>
<!-- End custom js for this page-->
<!-- date picker -->
<script src="../../components/datetimepicker/js/bootstrap-datepicker.js"></script>

<!-- call the function of select2 plug-in -->
<script>
$(document).ready(function(){
  $('.js-example-basic-single').select2();

  //SET THE CURRENT DATE IN EVERY DATETIMEPICKER
  $('#date_borrowed').datepicker({
    format: 'mm/dd/yyyy'
  }).datepicker('setDate', new Date());

  $('#date_retruned').datepicker({
    format: 'mm/dd/yyyy'
  });
});
</script>

<!-- autofocus in code -->
<script>
$(document).ready(function(){
  $('#code').focus();
})
</script>

<!-- search the code in db when changed -->
<script>
$('#code').change(function(){
  var code = $(this).val();

  $.ajax({
    type: 'POST',
    url: '../../controls/toolkeeper/get_tool_details.php',
    data: {code: code},
    dataType: 'json',
    cache: false,

    success: function(result)
    {
      var description = result[0];
      var brand = result[1];
      var serial = result[2];
      var barcode = result[3];
      var model = result[4];

      $('#description').val(description);
      $('#brand').val(brand);
      $('#serial').val(serial);
      $('#barcode').val(barcode);
      $('#model').val(model);
    }
  })
})
</script>

</body>
</html>