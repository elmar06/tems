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
  <link rel="stylesheet" href="../../css/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="../../images/Innoland.png" /> 
  <!-- plugin css for this page -->
  <link rel="stylesheet" href="../../components/font-awesome/css/font-awesome.css">
  <!-- select2 plugin -->
  <link rel="stylesheet" href="../../components/select2/select2.css">
  <!-- date picker -->
  <link rel="stylesheet" type="text/css" href="../../components/datetimepicker/css/datepicker.min.css">
</head>

<body>
<div class="container-scroller">
  <!-- page navbar -->
  <?php 
    include '../../includes/admin_header.php'; 
  ?>
  <!-- main panel -->
  <div class="container-fluid page-body-wrapper">
    <div class="content-wrapper">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <div>
                <button type="button" class="btn btn-primary btn-rounded" data-toggle="modal" data-target="#reportModal"><i class="fa fa-print"></i>Generate Report</button>
              </div><br>
              <table id="personnel_table" class="table table-bordered" style="width:100%">
                <thead>
                    <tr>
                      <th><center>Tool Code</center></th>
                      <th style="max-width: 150px;"><center>Description</center></th>
                      <th><center>From</th>
                      <th><center>To</center></th>
                      <th><center>Current Project</center></th>
                      <th><center>New Project</center></th>
                      <th><center>Date</center></th>
                    </tr>
                </thead>
                <tbody id="transfer-body">
                  <?php
                    $get_record = $records->view_transfer_records();
                    while($row1 = $get_record->fetch(PDO::FETCH_ASSOC))
                    {
                      $transfer_reason = $row1['reason'];
                      $transfer_date = $row1['transfer_date'];
                      $date = date('m/d/Y', strtotime($transfer_date));
                      $code = '';
                      $desc = '';
                      $from = '';
                      $to = '';
                      $cur_proj = '';
                      $new_proj = '';
                      //get the tool details
                      $asset->id = $row1['asset_id'];
                      $get = $asset->get_asset_byID();
                      while($tool = $get->fetch(PDO::FETCH_ASSOC))
                      {
                        $code = $tool['code'];
                        $desc = $tool['description'];
                      }
                      //get the old assignee name
                      $person->id = $row1['from_id'];
                      $view = $person->get_person_name();
                      while($from_row = $view->fetch(PDO::FETCH_ASSOC))
                      {
                        $from = $from_row['firstname'].' '.$from_row['lastname'];
                      }
                      //get the new assignee name
                      $person->id = $row1['to_id'];
                      $view = $person->get_person_name();
                      while($to_row = $view->fetch(PDO::FETCH_ASSOC))
                      {
                        $to = $to_row['firstname'].' '.$to_row['lastname'];
                      }
                      //get the current location
                      $loc->id = $row1['cur_proj'];
                      $curProj = $loc->view_loc_byID();
                      while($curRow = $curProj->fetch(PDO::FETCH_ASSOC))
                      {
                        $cur_proj = $curRow['location'];
                      }
                      //get the new location
                      $loc->id = $row1['new_proj'];
                      $newProj = $loc->view_loc_byID();
                      while($newRow = $newProj->fetch(PDO::FETCH_ASSOC))
                      {
                        $new_proj = $newRow['location'];
                      }
                       echo 
                        '<tr>
                          <td>'.$code.'</td>
                          <td style="max-width: 150px;">'.$desc.'</td>
                          <td>'.$from.'</td>
                          <td>'.$to.'</td>
                          <td>'.$cur_proj.'</td>
                          <td>'.$new_proj.'</td>
                          <td>'.$date.'</td>
                        </tr>';
                    }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div><!-- end of row -->
  </div><!-- end of container-fluid -->
</div><!-- end of container-scroller -->

<!-- content-wrapper ends -->
<!-- partial:partials/_footer.html -->
<footer class="footer">
  <div class="container-fluid clearfix">
    <center><span class="d-block text-center text-sm-left d-sm-inline-block">Copyright © 2019
      <a href="http://www.innogroup.com.ph/" target="_blank">Innoland Development Corporation</a>. All rights reserved.</span>
    </span></center>
  </div>
</footer>

<!-- MODALS SECTION -->
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
          <div class="col-sm-2">
            <label for="exampleInputEmail1">Date:</label><br>
          </div>
          <div class="col-sm-5">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text fa fa-calendar"></span>
              </div>
              <input type="text" class="form-control datepicker" id="date-from" placeholder="Date From"/>
            </div>
          </div>
          <div class="col-sm-5">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text fa fa-calendar"></span>
              </div>
              <input type="text" class="form-control datepicker" id="date-to" placeholder="Date to"/>
            </div>
          </div>
        </div><br><!-- end of row -->
        <div id="report-warning" class="alert alert-danger" role="alert" style="display: none"></div>
      </div>
      <div class="modal-footer">
        <button id="btnGenerate" class="btn btn-primary">Generate</button>
      </div>
    </div>
  </div>
</div> 

  <!-- data tables -->
  <script src="../../components/dataTables/js/jquery.dataTables.min.js"></script>
  <!-- plugins:js -->
  <script src="../../components/js/vendor.bundle.base.js"></script>
  <script src="../../components/js/vendor.bundle.addons.js"></script>
  <script src="../../js/off-canvas.js"></script>
  <script src="../../js/misc.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="../../js/dashboard.js"></script>
  <!-- select2 plugin -->
  <script src="../../components/select2/select2.min.js"></script>
  <!-- date picker -->
  <script src="../../components/datetimepicker/js/bootstrap-datepicker.js"></script>

  <!-- BOOTSTRAP TABLE FUNCTION -->
<script>
  $(function(){
    $('.table').DataTable();

    $('.datepicker').datepicker({
     format: 'mm/dd/yyyy'
    }).datepicker();

    $('.js-example-basic-single').select2();
  });
</script>
<!-- show the project option if tool keeper is selected -->
<script>
$('#RoleType').change(function(){
  var role = $(this).val(); 
  if(role == 3)
  {
    $('#proj_div').show();
  }
  else
  {
    $('#proj_div').hide();
  }
})
</script>

<!-- CHECK IF PASSWORD MATCH IN UPDATE USER DETAILS -->
<script>
$('#upd_password2').keyup(function(){
  var pass = $('#upd_password').val();
  var pass2 = $(this).val();
  //alert(pass);
  if(pass != pass2)
  {
    document.getElementById("pass_alert").innerHTML = "<label style='color:red'>ERROR! Password not match</label>";
  }
  else
  {
    document.getElementById("pass_alert").innerHTML = "<label style='color:green'>Password match</label>";
  }
})
</script>

<!-- SAVE USER FUNCTION -->
<script>
$('#save_user').click(function(e){
  e.preventDefault();

  var firstname = $('#fname').val();
  var lastname = $('#lname').val();
  var username = $('#username').val();
  var password = $('#password').val();
  var role = $('#RoleType').val();
  var project = $('#project').val();
  var myData = 'firstname=' + firstname + '&lastname=' + lastname + '&username=' + username + '&password=' + password + '&access_type=' + role + '&project=' + project;

  if(firstname != "" && lastname != "")
  {
    $.ajax({
      type: "POST",
      url: "../../controls/save_user.php",
      data: myData,

      success: function(response)
      {
        //alert(response);
        if(response > 0)
        {
          $('#save-success').html("<center><i class='fa fa-check menu-icon'></i> User successfully added.</center>");
          $('#save-success').show().fadeOut(5000);

          //page will reload after 2 seconds if success
          setTimeout(function(){
            location.reload();
          }, 1000)
        }
        else
        {
          $('#save-warning').html("<center><i class='fa fa-warning menu-icon'></i> Adding failed. Please contact the system administrator.</center>");
          $('#save-warning').show().fadeOut(5000);
        }
      },
      error: function(xhr, ajaxOptions, thrownError)
      {
        alert(thrownError);
      }
    })
  }
  else
  {
    $('#save-warning').html("<center><i class='fa fa-warning menu-icon'></i> Please fill-out all the field needed.</center>");
    $('#save-warning').show().fadeOut(5000);
  }
})
</script>

<!-- Report Generation functions -->
<script>
   $(document).ready(function(){
    //assignee
    $('#reportAssignee').change(function(){
      $('#clear_assign').attr('hidden', false);
      $('#reportDepartment').attr('disabled', true);
      $('#reportType').attr('disabled', true);
      $('.datepicker').attr('disabled', true);
    });
    //project
    $('#reportDepartment').change(function(){
      $('#clear_dept').attr('hidden', false);
      $('#reportAssignee').attr('disabled', true);
      $('#reportType').attr('disabled', true);
      $('.datepicker').attr('disabled', true);
    });
    //category
    $('#reportType').change(function(){
      $('#clear_type').attr('hidden', false);
      $('#reportDepartment').attr('disabled', true);
      $('#reportAssignee').attr('disabled', true);
      $('.datepicker').attr('disabled', true);
    })
    //Date
    $('#date-from').change(function(){
      $('#clear_date').attr('hidden', false);
      $('#reportDepartment').attr('disabled', true);
      $('#reportAssignee').attr('disabled', true);
      $('#reportType').attr('disabled', true);
    })
  });

  //CLEAR DATA in report category
  $('.clear-data').click(function(e){
    $('#reportAssignee').prop('selectedIndex',0);
    $('#reportDepartment').prop('selectedIndex',0);
    $('#reportType').prop('selectedIndex',0);
    $('.datepicker').val('');
    //enable fields
    $('#reportAssignee').attr('disabled', false);
    $('#reportDepartment').attr('disabled', false);
    $('#reportType').attr('disabled', false);
    $('.datepicker').attr('disabled', false);
    //hide the button after click event
    $(this).attr('hidden', true);
  });

  //GENRATE REPORT FUNCTION
  $('#btnGenerate').click(function(){
    var assignee = $('#reportAssignee').val();
    var project = $('#reportDepartment').val();
    var category = $('#reportType').val();
    var from = $('#date-from').val();
    var to = $('#date-to').val();
    var myData = 'assignee=' + assignee + '&project=' + project + '&category=' + category + '&from=' + from + '&to=' + to;

    if(assignee == null && project == null && category == null && from == '' && to == '')
    {
      $('#report-warning').html("<center><i class='fa fa-warning menu-icon'></i> Please choose a date for report. </center>");
      $('#report-warning').show();
      setTimeout(function(){
        $('#report-warning').fadeOut();
      }, 3000)
    }
    else
    {
      window.open('../../print/form/printAssetReport.php?' + myData);
    }
  })
</script>
</body>
</html>