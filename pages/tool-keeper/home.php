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
  <link rel="stylesheet" type="text/css" href="../../components/datetimepicker/css/bootstrap-datetimepicker.min.css">
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
              <h4><b>PROJECT: <u> <?php echo $_SESSION['proj-name']; ?></u></b></h4>
              <div class="card">
                <div class="card-body">
                  <h5><span class="fa fa-database"></span> Tool & Equipment Details</h5>
                  <div class="row">
                    <div class="col-lg-8">
                      <label for="exampleInputEmail1" style="font-size: 16px">Tools & Equipment Code</label>&nbsp;<span style="color: red; font-size: 16px">*</span>
                      <input type="text" class="form-control" id="code" placeholder="Please scan the Code" required="required">
                    </div>
                    <div class="col-lg-4">
                      <center><label style="font-size: 16px">T & E Status</label><br>
                      <label id="tool-status" style="font-size: 20px"></label></center>
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
                      <input type="text" class="form-control" id="tool-id" hidden>
                      <input type="text" class="form-control" id="record-id" hidden>
                      <input type="text" class="form-control" id="status" hidden>
                    </div>
                  </div><br>
                  <div class="row">
                    <div class="col-lg-12">
                      <div id="tool-warning" class="alert alert-danger" role="alert" style="display: none"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div><!-- end of form-group -->
            <!-- Worker Details -->
            <div class="form-group col-lg-6">
            <h4>&nbsp;</h4>
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
                      <input type="text" class="form-control" id="emp-name" disabled>
                    </div>
                    <div class="col-lg-6">
                      <label for="exampleInputEmail1">Trade</label>
                      <input type="text" class="form-control" id="emp-trade" disabled>
                    </div>
                  </div><br>
                  <div class="row">
                    <div class="col-sm-6">
                      <label for="exampleInputEmail1">Date Borrowed</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text fa fa-calendar"></span>
                          </div>
                          <input type="text" class="form-control" id="date_borrowed" disabled>
                        </div>
                    </div>
                     <div class="col-sm-6">
                      <label for="exampleInputEmail1">Date Returned</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text fa fa-calendar"></span>
                          </div>
                          <input type="text" class="form-control" id="date_returned" disabled/>
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
                      <div id="emp-warning" class="alert alert-danger" role="alert" style="display: none"></div>
                      <div id="borrow-success" class="alert alert-success" role="alert" style="display: none"></div>
                      <div id="borrow-warning" class="alert alert-danger" role="alert" style="display: none"></div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-10">                      
                      <button id="clear" type="button" class="btn btn-default pull-right" onclick="clearFields()">Clear</button>
                    </div>
                    <div class="col-lg-2">                      
                      <button id="btnSubmit" type="button" class="btn btn-primary pull-right">Submit</button> 
                    </div>
                    <div class="col-lg-12 borrowers-detail" style="display: none;">
                      <label for="exampleInputEmail1" style="font-size: 16px">Borrower Details</label><br>
                      <label>Emp Code:</label>&nbsp;<label id="borrowers-code"></label><br>
                      <label>Emp Name:</label>&nbsp;<label id="borrowers-name"></label>
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
<script src="../../components/datetimepicker/js/bootstrap-datetimepicker.js"></script>
<!-- toast js -->
<script src="../../components/js/jquery.toast.js"></script>

<!-- call the function of select2 plug-in -->
<script>
//toast
function showToast(){
  var title = 'Loading...';
  var duration = 500;
  $.Toast.showToast({title: title,duration: duration, image: '../../components/img/loading.gif'});
}
function hideLoading(){
  $.Toast.hideToast();
}
//select2 
$(document).ready(function(){
  $('.js-example-basic-single').select2();

  //SET THE CURRENT DATE IN EVERY DATETIMEPICKER
  $('#date_borrowed').datepicker({
    format: 'mm/dd/yyyy'
  }).datepicker('setDate', new Date());

});
//autofocus in code
$(document).ready(function(){
  $('#code').focus();
})

//search the T&E code in db when changed
$('#code').change(function(){
  var code = $(this).val();
  var proj_id = $('#proj-id').val();
  var myData = 'code=' + code + '&proj_id=' + proj_id;

  $.ajax({
    type: 'POST',
    url: '../../controls/toolkeeper/get_tool_details.php',
    data: myData,
    dataType: 'json',
    cache: false,

    success: function(result)
    {
      if(result == ''){
        $('#tool-warning').html("<center><i class='fa fa-warning menu-icon'></i> ERROR! Tool not found!.</center>");
        $('#tool-warning').show();
        setTimeout(function(){
          $('#tool-warning').fadeOut();
        }, 3000)
        //clear input fields
        clearToolData();
      }else{
        //initialize data
        var description = result[0];
        var brand = result[1];
        var serial = result[2];
        var barcode = result[3];
        var model = result[4];
        var status = result[5];
        var id = result[6];
        //display data in the input box
        $('#description').val(description);
        $('#brand').val(brand);
        $('#serial').val(serial);
        $('#barcode').val(barcode);
        $('#model').val(model);
        $('#tool-id').val(id);
        $('#status').val(status);
        //check the status of tools & equipment
        if(result[5] == 1){
         $('#tool-status').html('<label id="tool-status" style="font-size: 20px; color: green;">In Storage</label>');
         $('#date-returned').val('');
        }
        else if(result[5] == 2){
         $('#tool-status').html('<label id="tool-status" style="font-size: 20px; color: green;">Returned</label>');
         $('#date-returned').val('');
        }else{
          $('#tool-status').html('<label id="tool-status" style="font-size: 20px; color: red;">For Returned</label>');  
          //check the records table and get the id to update the status
          var tool_id = result[6];
          var myData = 'tool_id=' + tool_id + '&tool_code=' + code;
          
          $.ajax({
            type: 'POST',
            url: '../../controls/toolkeeper/check_record.php',
            data: myData,
            dataType: 'json',
            cache: false,
            success: function(result)
            {
              var id = result[0];
              var date_borrowed = result[1];
              var borrowers_code = result[2];
              var borrowers_name = result[3];
              $('#record-id').val(id);
              $('#date_borrowed').val(date_borrowed);
              //display the name of borrower
              $('#borrowers-code').text(borrowers_code);  
              $('#borrowers-name').text(borrowers_name);  
              $('.borrowers-detail').show(300);
            }
          })
        }        
      }
    },
    error: function(xhr, ajaxOptions, thrownError)
    {
      alert(thrownError);
    }
  })
})
//search employee ID in db
$('#borrow-code').change(function(){
  var emp_code = $(this).val();
  var project = $('#proj-id').val();
  var myData = 'emp_code=' + emp_code + '&project=' + project;

  $.ajax({
    type: 'POST',
    url: '../../controls/toolkeeper/get_emp_details.php',
    data: myData,
    dataType: 'json',
    cache: false,
    success: function(result)
    {
      if(result == ''){
        $('#emp-warning').html("<center><i class='fa fa-warning menu-icon'></i> ERROR! Worker details not found!.</center>");
        $('#emp-warning').show();
        setTimeout(function(){
          $('#emp-warning').fadeOut();
        }, 3000)
        clearWorkerData();
      }else{
         //initialize data
        var name = result[0];
        var trade = result[1];
        //display data in the input box
        $('#emp-name').val(name);
        $('#emp-trade').val(trade);
         //set the date returned
         $('#date_returned').datetimepicker({
          format: 'mm/dd/yyyy hh:mm',
        }).datepicker('setDate', new Date());
      }
    },
    error: function(xhr, ajaxOptions, thrownError)
    {
      alert(thrownError);
    }
  })
})
//btnSubmit event handler
$('#btnSubmit').on('click', function(e){
  e.preventDefault();

  var project = $('#proj-id').val();
  var tool_id = $('#tool-id').val();
  var tool_code = $('#code').val();
  var description = $('#description').val();
  var borrow_code = $('#borrow-code').val();
  var name = $('#emp-name').val();
  var date_borrow = $('#date_borrowed').val();
  var date_return = $('#date_returned').val();
  var record_id = $('#record-id').val();
  var status = $('#status').val();
  var add_by = $('#acc_id').val();
  var myData = 'project=' + project + '&tool_id=' + tool_id + '&tool_code=' + tool_code + '&description=' + description + '&borrow_code=' + borrow_code + '&name=' + name + '&date_borrow=' + date_borrow + '&date_return=' + date_return + '&record_id=' + record_id + '&add_by=' + add_by;

  if(tool_code != '' & borrow_code != '')
  {
    if(status == 1 || status == 2)//if tools are in storage
    {
      $.ajax({
        type: 'POST',
        url: '../../controls/toolkeeper/borrow_tool.php',
        data: myData,
        beforeSend: function()
        {
          showToast();
        },
        success: function(response)
        {
          if(response > 0)
          {
            $('#borrow-success').html("<center><i class='fa fa-check menu-icon'></i> Transaction saved!.</center>");
            $('#borrow-success').show();
            setTimeout(function(){
              $('#borrow-success').fadeOut();
            }, 2000)
          }
          else
          {
            $('#borrow-warning').html("<center><i class='fa fa-warning menu-icon'></i> ERROR! Please contact the system administrator at local 124 for assistance.</center>");
            $('#borrow-warning').show();
            setTimeout(function(){
              $('#borrow-warning').fadeOut();
            }, 3000)
          }
        },
        error: function(xhr, ajaxOptions, thrownError)
        {
          alert(thrownError);
        }
      })
    }
    else//if tools are BORROWED
    {
      $.ajax({
        type: 'POST',
        url: '../../controls/toolkeeper/return_tool.php',
        data: myData,
        beforeSend: function()
        {
          showToast();
        },
        success: function(response)
        {
          if(response > 0)
          {
            $('#borrow-success').html("<center><i class='fa fa-check menu-icon'></i> T&E Successfully mark as RETURNED!.</center>");
            $('#borrow-success').show();
            setTimeout(function(){
              $('#borrow-success').fadeOut();
            }, 2000)
          }
          else
          {
            $('#borrow-warning').html("<center><i class='fa fa-warning menu-icon'></i> ERROR! Please contact the system administrator at local 124 for assistance.</center>");
            $('#borrow-warning').show();
            setTimeout(function(){
              $('#borrow-warning').fadeOut();
            }, 3000)
          }
        },
        error: function(xhr, ajaxOptions, thrownError)
        {
          alert(thrownError);
        }
      })
    }
  }
  else
  {
    $('#borrow-warning').html("<center><i class='fa fa-warning menu-icon'></i> ERROR! Please fill out all the data needed.</center>");
    $('#borrow-warning').show();
    setTimeout(function(){
      $('#borrow-warning').fadeOut();
    }, 3000)
  }
})

//clear functions
function clearFields()
{
  $('input[type=text]').val('');
  $('textarea').val('');
  $('#tool-status').html('<label id="tool-status" style="font-size: 20px;"></label>');
}
//clear tools & equipment details except for barcode
function clearToolData()
{
  $('#description').val('');
  $('#brand').val('');
  $('#serial').val('');
  $('#barcode').val('');
  $('#model').val('');
}
//clear worker details
function clearWorkerData()
{
  $('#emp-name').val('');
  $('#emp-trade').val('');
}
</script>

</body>
</html>