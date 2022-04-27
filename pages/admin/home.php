<?php 
  include '../../includes/admin_header.php';//include the header 
    if(!$_SESSION['username'])
    {
      header("Location: index.php");
    }
?>
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
  <!-- inject:css -->
  <link rel="stylesheet" href="../../css/style.css">
  <!-- endinject -->
  <link rel="icon" type="image/png" href="../../images/Innoland.png">
  <!-- plugin css for this page -->
  <link rel="stylesheet" href="../../components/font-awesome/css/font-awesome.css">
   <!-- date picker -->
  <link rel="stylesheet" type="text/css" href="../../components/datetimepicker/css/datepicker.min.css">
  <!-- select2 plugin -->
  <link rel="stylesheet" href="../../components/select2/select2.css">
</head>

<body>
<div class="container-scroller">
  <!-- page navbar -->
  <input style="display:none" id="log_count" value="<?php echo $_SESSION['log_count']; ?>">
  <!-- main panel -->
    <div class="container-fluid page-body-wrapper">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-lg-12">
              <div class="card">
                <div class="card-body">
                  <div>
                    <a href="add_asset.php" class="btn btn-success btn-rounded"><span class="fa fa-plus"></span> New Tool/Equipment</a>
                    <button id="btnEdit" class="btn btn-dark btn-rounded"><i class="fa fa-edit"></i>Edit Asset</button>
                    <!-- <a id="viewAsset" href="home.php" class="btn btn-dark btn-rounded"><i class="fa fa-list"></i>View All Assets</a> -->
                    <a id="btnTransfer" href="#" class="btn btn-primary btn-rounded"><i class="fa fa-share"></i>Transfer Asset</a>
                    <button id="btnReport" class="btn btn-primary btn-rounded" data-toggle="modal" data-target="#reportModal"><i class="fa fa-print"></i>Reports</button>
                  </div><br>
                  <div id="table-content">
                  <table id="asset_table" class="table table-bordered table-responsive table-hover asset_table" style="cursor:pointer">
                    <thead>
                        <tr>
                            <th align="center"  style="max-width: 5%;"><input type="checkbox" id="checkboxall"/></th>
                            <th align="center" style="max-width: 80px;">T&E Code</th>
                            <th align="center" style="max-width: 80px;">Serial No.</th>
                            <th align="center" style="max-width: 200px;">Description</th>
                            <th align="center" style="max-width: 150px;">Project</th>
                            <th align="center" style="max-width: 150px;">Category</th>
                            <th align="center" style="max-width: 100px;">Trade</th>
                            <th align="center" style="max-width: 100px;">Assignee</th>
                            <th align="center" style="width: 10%;">Condition</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php
                        //$asset->project = $_SESSION['project-id'];
                        $view = $asset->view_asset();

                        while($row = $view->fetch(PDO::FETCH_ASSOC))
                        {
                          extract($row);
                          if($row['serial'] == ''){
                            $serial = '-';
                          }
                          echo '
                            <tr>
                              <td><input type="checkbox" name="checklist" class="checklist" value="'.$row['asset_id'].'" style="max-width: 5%;"></td>
                              <td class="barcode" style="max-width: 80px;">'.$row['code'].'</td>
                              <td class="barcode" style="max-width: 80px;"><center>'.$serial.'<center></td>
                              <td class="description" style="max-width: 200px;">'.$row['description'].'</td>
                              <td class="asset_type" style="max-width: 150px;">'.$row['loc_name'].'</td>
                              <td class="asset_loc" style="max-width: 150px;">'.$row['cat_name'].'</td>
                              <td class="brand" style="max-width: 100px;">'.$row['dept_name'].'</td>
                              <td class="brand" style="max-width: 100px;">'.$row['fullname'].'</td>
                              <td class="asset_status" style="width: 10%;">'.$row['tool_condition'].'</td>
                            </tr>';
                        }
                      ?>
                    </tbody>
                  </table>
                  </div><!-- end of table content div -->
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
<!-- transfer asset modal -->
<div class="modal fade" id="transferModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><span class="fa fa-sign-in"></span> Transfer Asset</h5>
        <button type="button" class="close close-asset" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="transfer-body" class="modal-body">
        <div class="form-group">
          <div class="row">
              <div class="col-lg-4">
                <label for="exampleInputEmail1">TRANSFER DETAILS</label>
              </div>
          </div>
            <div class="row">
                <div class="col-lg-4">
                  <label for="exampleInputEmail1">New Assignee</label><br>
                  <select id="newAssign" type="text" class="form-control select2" style="width: 100%">
                    <?php
                      $view_person = $person->view_person();
                      while($person_row = $view_person->fetch(PDO::FETCH_ASSOC))
                      {
                        echo '<option value='.$person_row['person_id'].'>'.$person_row['fullname'].'</option>';
                      }
                    ?>
                  </select>
                </div>
                <div class="col-lg-4">
                  <label>Date Transfer </label><br>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text fa fa-calendar"></span>
                    </div>
                    <input id="date_transfer" type="text" class="form-control transfer-date"/>
                  </div>
              </div>
                <div class="col-lg-4"> 
                  <label for="exampleInputEmail1">Reason</label>
                  <select type="text" class="form-control select2" id="reason" style="width: 100%;">
                    <option>Transfer to Inventory</option>
                    <option>Transfer from Inventory</option>
                    <option>Transfer Assignee</option>
                    <option>Transfer to another Location</option>
                    <option>Temporary</option>
                    <option>Resignee</option>
                  </select>
                </div>
            </div><br>
            <div class="row">
                <div class="col-lg-4"> 
                  <label for="exampleInputEmail1">New Project</label><br>
                  <select id="new_location" type="text" class="form-control select2" style="width: 100%">
                      <?php
                        $view_loc = $loc->view_loc();
                        while($loc_row=$view_loc->fetch(PDO::FETCH_ASSOC))
                        {
                          echo '<option value='.$loc_row['id'].'>'.$loc_row['location'].'</option>';
                        }
                      ?>
                  </select>
                </div>
                <div class="col-lg-4"> 
                  <label for="exampleInputEmail1">New Trade</label><br>
                  <select id="new_department" type="text" class="form-control select2" style="width: 100%">
                      <?php
                        $view_dept = $dept->view_dept();
                        while($dept_row=$view_dept->fetch(PDO::FETCH_ASSOC))
                        {
                          echo '<option value='.$dept_row['id'].'>'.$dept_row['department'].'</option>';
                        }
                      ?>
                  </select>
                </div>
                <div class="col-lg-4">
                  <label for="exampleInputEmail1">Quantity</label>
                  <input type="text" class="form-control" id="quantity" placeholder="Enter Quantity" value="1">
                </div>
            </div><hr>
            <div class="row" style="font-size: 13px;">
                <div class="col-lg-12">
                  <label for="exampleInputEmail1">LIST OF ITEM TO TRANSFER</label>
                  <table id="tbltransfer" class="table-bordered transfer_table" style="width: 100%">
                    <thead>
                        <tr>
                          <th></th>
                            <th>T&E Code</th>
                            <th>Description</th>
                            <th>Project</th>
                            <th>Category</th>
                            <th>Trade</th>
                            <th>Assignee</th>
                            <th>Condition</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="tbody-transfer">
                      <!-- asset items must be placed here -->
                    </tbody>
                  </table>
                </div>
            </div>
        </div><!-- end of form group -->
        <!-- Alerts -->
        <div id="transfer-warning" class="alert alert-danger" role="alert" style="display: none"></div>
        <div id="transfer-success" class="alert alert-success" role="alert" style="display: none"></div>        
      </div><!-- end of modal body -->
      <div class="modal-footer">
        <div class="row">
          <div class="col-lg-12">
            <button id="btnPrintTransfer" type="button" class="btn btn-success" disabled="">Print Fixed Asset Transfer</button>
            <!-- <button id="btnPrintReceipt" type="button" class="btn btn-info" disabled>Print Pull-out Receipt</button> -->
            <button id="btnClose" class="btn btn-secondary close-asset" data-dismiss="modal">Close</button>
            <button id="btnAssetTransfer" type="button" class="btn btn-primary">Transfer</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- reports generation modal -->
<div id="reportModal" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><span class="fa fa-bar-chart"></span> Report Generation</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-sm-12">
            <p><i>Generate report by:</i></p>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-3">
            <label for="exampleInputEmail1">Assignee:</label><br>
          </div>
          <div class="col-sm-8">
            <select id="reportAssignee" type="text" class="form-control" style="width: 100%">
              <option value="" selected disabled>Please select assignee</option>
              <?php
                $view_person = $person->view_person();
                while($person_row = $view_person->fetch(PDO::FETCH_ASSOC))
                {
                  echo '<option value='.$person_row['person_id'].'>'.$person_row['fullname'].'</option>';
                }
              ?>
            </select>
          </div>
          <div class="col-sm-1">
            <button id="clear_assign" type="button" class="close clear-data" aria-label="Close" hidden>
              <span style="color: red" class="fa fa-remove"></span>
            </button>
          </div>
        </div><br><!-- end of row -->
        <div class="row">
          <div class="col-sm-3">
            <label for="exampleInputEmail1">Project:</label><br>
          </div>
          <div class="col-sm-8">
            <select id="reportDepartment" type="text" class="form-control" style="width: 100%">
              <option value="" selected disabled>Please select Project</option>
                <?php
                  $view = $loc->view_loc();
                  while($row=$view->fetch(PDO::FETCH_ASSOC))
                  {
                    echo '<option value='.$row['id'].'>'.$row['location'].'</option>';
                  }
                ?>
            </select>
          </div>
          <div class="col-sm-1"> 
            <button id="clear_dept" type="button" class="close clear-data" aria-label="Close" hidden>
              <span style="color: red" class="fa fa-remove"></span>
            </button>
          </div>
        </div><br><!-- end of row -->
         <div class="row">
          <div class="col-sm-3">
            <label for="exampleInputEmail1">Category:</label><br>
          </div>
          <div class="col-sm-8">
            <select id="reportType" type="text" class="form-control" style="width: 100%">
              <option value="" selected disabled>Please select Trade</option>
                <?php
                  $viewType = $type->view_type();
                  while($row = $viewType->fetch(PDO::FETCH_ASSOC))
                  {
                    echo '<option value='.$row['id'].'>'.$row['type'].'</option>';
                  }
                ?>
            </select>
          </div>
          <div class="col-sm-1">
            <button id="clear_type" type="button" class="close clear-data" aria-label="Close" hidden>
              <span style="color: red" class="fa fa-remove"></span>
            </button>
          </div><!-- end of column -->
        </div><br><!-- end of row -->
        <div id="report-warning" class="alert alert-danger" role="alert" style="display: none"></div>
      </div>
      <div class="modal-footer">
        <button id="btnGenerate" class="btn btn-primary">Generate</button>
      </div>
    </div>
  </div>
</div> 

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

<!-- View Asset Details -->
<div id="viewAssetModal" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel"><span class="fa fa-bar-chart"></span> Asset Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="viewAssetBody" class="modal-body">

      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>  
<!-- jquery -->
<script src="../../components/jquery/jquery-3.4.1.min.js"></script>
<!-- data tables -->
<script src="../../components/dataTables/js/jquery.dataTables.min.js"></script>
<!-- plugins:js -->
<script src="../../components/js/vendor.bundle.base.js"></script>
<script src="../../components/js/vendor.bundle.addons.js"></script>
<!-- inject:js -->
<script src="../../js/off-canvas.js"></script>
<script src="../../js/misc.js"></script>
<!-- Custom js for this page-->
<script src="../../js/dashboard.js"></script>
<!-- select2 plugin -->
<script src="../../components/select2/select2.min.js"></script>
<!-- date picker -->
<script src="../../components/datetimepicker/js/bootstrap-datepicker.js"></script>

<!-- call the function of select2 plug-in -->
<script>
$(document).ready(function(){
  $('.select2').select2();

  //SET THE CURRENT DATE IN EVERY DATETIMEPICKER
  $('.transfer-date').datepicker({
    format: 'mm/dd/yyyy'
  }).datepicker('setDate', new Date());

  $('#report_date').datepicker({
    format: 'mm/dd/yyyy'
  });
});
</script>

<!-- BOOTSTRAP DATATABLE FUNCTION -->
<script>
  $(function(){
    $('.table').DataTable();
  });
</script>

<!-- Get the data from asset_table when doubleclicking -->
<script>
  $(document).on('dblclick', '#asset_table tr', function(){
    var id = $(this).find('td:eq(0) input:checkbox[name=checklist]').val();

    $.ajax({
      type: 'POST',
      url: '../../controls/view_asset_byID.php',
      data: {id:id},

      success: function(html)
      {
        $('#viewAssetModal').modal('show');
        $('#viewAssetBody').html(html);
      },
      error: function(xhr, ajaxOptions, thrownError)
      {
        alert(thrownError);
      }
    })
  })
</script>

<!-- SET Asset to TRANSFER Function -->
<script>
  $(document).ready(function(){
    $('body').on('click', '#btnTransfer', function(e){
      e.preventDefault();

        if($('.asset_table td input:checked').length > 0)
        {
          $('.asset_table td input:checked').each(function(){
            tr = $(this).parent().parent();
            tr.append($('<td>', {
              class: 'btnremove',
              html: 'Remove',
              style: 'text-decoration:underline;cursor:pointer;color:red'
            }))
            $('.transfer_table').append(tr.clone());
            tr.find('input:checked').attr('disabled', true);
            tr.remove();
            $('#transferModal').modal('show');
          });
        }
        else
        {
          $('#transferModal').modal('show');
          $('#btnPrintTransfer').attr('disabled', true);
          $('#btnPrintReceipt').attr('disabled', true);
          $('#btnAssetTransfer').attr('disabled', true);
          $('#transfer-warning').html("<center><i class='fa fa-warning menu-icon'></i> No Item selected for Transfer.</center>");
          $('#transfer-warning').show().fadeOut(5000);
        }
    })
    //Remove asset in the list when clicking the remove button
    $('body').on('click', '.btnremove', function(e){
      tr = $(this).parent();
      tr.find('.btnRemove').remove();
      $('#tbltransfer th:last-child, #tbltransfer td:last-child').remove();//Remove the action button
      $('.asset_table').append(tr.clone());
      tr.remove();
    })

    //enable button after closing the modal transfer asset
    $('.close-asset').click(function(){
      $('#btnPrintTransfer').attr('disabled', false);
      $('#btnAssetTransfer').attr('disabled', false);
    })
  })
</script>

<!-- transfer the data after asset transfer is done -->
<script>
$('#btnPrintTransfer').click(function(e){
  e.preventDefault();

  //get the id of asset items
  var id = [];
  $('input:checkbox[name=checklist]:checked').each(function(){
    id.push($(this).val());
  });
  //get the data from transfer table
  var data = [];
  $('.transfer_table td').each(function(){
    data.push($(this).text());
  });

    var oldLocation = data[3];
    var oldAssignee = data[6];
    var oldDept = data[5];

    var new_assignee = $('#newAssign').val();
    var date_transfer = $('#date_transfer').val();
    var reason = $('#reason').val();
    var new_location = $('#new_location').val();
    var quantity = $('#quantity').val();
    var department = $('#new_department').val();
    var myData = 'new_assignee=' + new_assignee + '&date_transfer=' + date_transfer + '&reason=' + reason + '&new_location=' + new_location + '&quantity=' + quantity + '&department=' + department + '&oldLocation=' + oldLocation + '&oldAssignee=' + oldAssignee + '&oldDept=' + oldDept + '&id=' + id;
    //passing of data to tcpdf page
    window.open('../../print/form/printARTF3.php?' + myData);
})
</script>

<script>
  $('#btnGenerate').click(function(){
    var assignee = $('#reportAssignee').val();
    var project = $('#reportDepartment').val();
    var category = $('#reportType').val();

    if(assignee != null)
    {
      window.open('../../print/form/printAssetByAssign.php?assignee=' + assignee);
    }
    
    if(project != null)
    {
      window.open('../../print/form/printAssetByProject.php?project=' + project);
    }
    
    if(category != null)
    {
      window.open('../../print/form/printAssetByCategory.php?category=' + category);
    }

    if(assignee == null && project == null && category == null)
    {
      $('#report-warning').html("<center><i class='fa fa-warning menu-icon'></i> Please choose a report to generate. </center>");
      $('#report-warning').show().fadeOut(5000);
    }
  })
</script>

<!-- Transfer Asset Function -->
<script>
$('#btnAssetTransfer').click(function(){
  var id = [];
  $('input:checkbox[name=checklist]:checked').each(function(){
    id.push($(this).val());
  });

  var assign = $('#newAssign').val();
  var date_transfer = $('#date_transfer').val();
  var reason = $('#reason').val();
  var location = $('#new_location').val();
  var quantity = $('#quantity').val();

  $.each(id, function(key, value){
    $.ajax({
      type: 'POST',
      url: '../../controls/transfer_asset.php',
      data: {id: value, assign: assign, date_transfer: date_transfer, reason: reason, location: location, quantity: quantity},

      success: function(response)
      {
        if(response > 0)
        {
          $('#transfer-success').html("<center><i class='fa fa-check menu-icon'></i> Asset Successfully transfer to new Assignee.</center>");
          $('#transfer-success').show().fadeOut(5000);
          $('#btnPrintTransfer').attr('disabled', false);
          $('#btnPrintReceipt').attr('disabled', true);
          $('#btnAssetTransfer').attr('disabled', true);
        }
        else
        {
          $('#transfer-warning').html("<center><i class='fa fa-warning menu-icon'></i> Transfer Failed. Please contact the administrator.</center>");
          $('#transfer-warning').show().fadeOut(5000);
        }
      },
      error: function(xhr, ajaxOptions, thrownError)
      {
        alert(thrownError);
      }
    })
  })
})
</script>

<!-- BTNEDIT ASSET FUNCTION -->
<script>
$('#btnEdit').click(function(e){
  e.preventDefault();
  var id = [];
  $('input:checkbox[name=checklist]:checked').each(function(){
    id.push($(this).val());
  })
  
  //check if checkbox is null/empty
  if($('input:checkbox[name=checklist]:checked').length > 0)
  { 
    window.location = 'update_asset.php?id=' + id;
  }
  else
  {
    alert('ERROR! Please select asset to update.');
  }
})
</script>

<!-- check if password match -->
<script>
$('#re_pass').keyup(function(){
  var new_pass = $('#new_pass').val();
  var re_pass = $(this).val();

  if(new_pass != re_pass)
  {
    document.getElementById("pass_alert").innerHTML = "<label style='color:red'>ERROR! Password not match</label>";
    $('#upd_pass').attr('disabled', true);
  }
  else
  {
    document.getElementById("pass_alert").innerHTML = "<label style='color:green'>Password match</label>";
    $('#upd_pass').attr('disabled', false);
  }
})
</script>

<!-- change password if first time to log-in -->
<script>
$(document).ready(function(){
  var log_count = $('#log_count').val();

  if(log_count == "0" || log_count == 0)
  {
    $('#changepass').modal({backdrop: 'static', keyboard: false});
  }
})
</script>

<!-- SAVE CHANGES(1st time to login) -->
<script>
$(document).on('click', '#upd_pass', function(e){
  e.preventDefault();

  var id = $('#id').val();
  var password = $('#new_pass').val();
  var password2 = $('#re_pass').val();
  var command = 1;
  var myData = 'id=' + id + '&password=' + password + '&command=' + command; 

  if(password == "" || password2 == "")
  {
    $('#error_msg').html("WARNING! Please input or re-type your password.");
    $('#error_msg').show().fadeOut(5000);   
  }
  else
  {
    $.ajax({
      type: "POST",
      url: "../../controls/update_password.php",
      data: myData, 

      success: function(response)
      {
        //alert(response);
        if(response > 0)
        {
          $('#changepass').fadeOut('slow');
          $('#noticeModal').modal({backdrop: 'static', keyboard: false});
        }
        else
        {
          $('#error_msg').html("<center><i class='fa fa-warning menu-icon'></i> Update Failed. Please contact the system administrator.</center>");
          $('#error_msg').show().fadeOut(5000); 
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

<!-- change password later -->
<script>
$('#later_pass').click(function(e){
  e.preventDefault();

  var id = $('#id').val();
  var command = 0;
  var myData = 'id=' + id + '&command=' + command;

  $.ajax({
    type: "POST",
    url: "../../controls/update_password.php",
    data: myData,

    success: function(response)
    {
      if(response > 0)
      {
        $('#changepass').fadeOut('slow');
      }
      else
      {
        $('#error_msg').html("<center><i class='fa fa-warning menu-icon'></i> Update Failed. Please contact the system administrator.</center>");
        $('#error_msg').show().fadeOut(5000); 
        return false;
      }
    },
    error: function(xhr, ajaxOptions, thrownError)
    {
      alert(thrownError);
    }
  })
})  
</script>

<!-- Report Generation input functions -->
<script>
   $(document).ready(function(){
    //assignee
    $('#reportAssignee').change(function(){
      $('#clear_assign').attr('hidden', false);
      $('#reportDepartment').attr('disabled', true);
      $('#reportType').attr('disabled', true);
    });
    //department
     $('#reportDepartment').change(function(){
      $('#clear_dept').attr('hidden', false);
      $('#reportAssignee').attr('disabled', true);
      $('#reportType').attr('disabled', true);
    });
    //date
     $('#reportType').change(function(){
      $('#clear_type').attr('hidden', false);
      $('#reportDepartment').attr('disabled', true);
      $('#reportAssignee').attr('disabled', true);
    })
  });

  //CLEAR DATA in report category
  $('.clear-data').click(function(e){
    $('#reportAssignee').prop('selectedIndex',0);
    $('#reportDepartment').prop('selectedIndex',0);
    $('#reportType').prop('selectedIndex',0);
    //enable fields
    $('#reportAssignee').attr('disabled', false);
    $('#reportDepartment').attr('disabled', false);
    $('#reportType').attr('disabled', false);
    //hide the button after click event
    $(this).attr('hidden', true);
  });
</script>

<!-- checkbox functions -->
<script>
$('#checkboxall').change(function(){
  if($(this).prop('checked'))
  {
    $('tbody tr td input[type="checkbox"]').each(function(){
      $(this).prop('checked', true);

      var selected = $.map($('input[name="checklist"]:checked'), function(c){return c.value;});
      if(selected.length > 1)
      {
        $('#btnEdit').hide();
        $('#btnReport').hide();
        $('#viewAsset').hide();
      }
      else
      {
        $('#btnEdit').show();
        $('#btnReport').show();
        $('#viewAsset').show();
      }
    });
  }
  else
  {
    $('tbody tr td input[type="checkbox"]').each(function(){
      $(this).prop('checked', false);
      
      $('#btnEdit').show();
      $('#btnReport').show();
      $('#viewAsset').show();
    });
  }
});

//checklist functions
$(document).on('change', '.checklist', function(){
  var selected = $.map($('input[name="checklist"]:checked'), function(c){return c.value;});
  if(selected.length > 1)
  {
    $('#btnEdit').hide();
    $('#btnReport').hide();
    $('#viewAsset').hide();
  }
  else
  {
    $('#btnEdit').show();
    $('#btnReport').show();
    $('#viewAsset').show();
  }
});
</script>

</body>
</html>