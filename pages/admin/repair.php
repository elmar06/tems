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
  <link rel="shortcut icon" href="../../images/Innoland.png" /> 
  <!-- plugin css for this page -->
  <link rel="stylesheet" href="../../components/font-awesome/css/font-awesome.css">
  <!-- select2 plugin -->
  <link rel="stylesheet" href="../../components/select2/select2.css">
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
          <div>
            <button type="button" id="btnMark" class="btn btn-success btn-rounded" data-toggle="modal" data-target="#updConditionModal"><i class="fa fa-plus"></i>Change T&E Status</button>
            <button type="button" class="btn btn-primary btn-rounded" data-toggle="modal" data-target="#newPersonnelModal"><i class="fa fa-print"></i>Generate Report</button>
          </div><br>
          <div class="card">
            <div class="card-body">
              <!-- tab pane navigation -->
              <ul class="nav nav-tabs" role="tablist">
                  <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#forRepairTabPanel" role="tab"><span class="mdi mdi-format-list-numbers"></span> Tools For Repair</a> </li>
                  <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#underRepairTabPanel" role="tab"><span class="mdi mdi-autorenew"></span> Under Repair</a> </li>
                  <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#repairHistoryTabPanel" role="tab"><span class="mdi mdi-checkbox-multiple-marked-circle"></span> Repair History</a> </li>
              </ul>
              <!-- Tools for Repair -->
              <div class="tab-content tabcontent-border">
                <div class="tab-pane active" id="forRepairTabPanel" role="tabpanel"><br>
                <div><h4 class="page-title" style="color: Red">&nbsp; List of Tools for Repair</h4></div><br>
                  <div class="table-responsive">
                    <table id="personnel_table" class="table table-bordered" style="width:100%">
                    <thead>
                        <tr>
                          <th style="width:5%"><center><input type="checkbox" id="checkboxall"></center></th>
                          <th>Tool Code</th>
                          <th style="max-width: 400px;">Description</th>
                          <th><center>Project</center></th>
                          <th style="max-width: 300px;"><center>Remarks</center></th>
                        </tr>
                    </thead>
                    <tbody id="listForRepairs">
                      <?php
                        $get = $asset->get_asset_for_repair();
                        while($row = $get->fetch(PDO::FETCH_ASSOC))
                        {
                          echo '
                            <tr>
                                <td><input type="checkbox" name="checklist" class="checklist" value="'.$row['asset_id'].'"></td>
                                <td>'.$row['code'].'</td>
                                <td style="max-width: 400px;">'.$row['description'].'</td>
                                <td><center>'.$row['location'].'</center></td>
                                <td style="max-width: 300px;">'.$row['repair_remark'].'</td>
                              </tr>';
                        }
                      ?>
                    </tbody>
                    </table>
                  </div>
                </div>
                <!-- Tools Under Repair -->
              <div class="tab-pane" id="underRepairTabPanel" role="tabpanel"><br>
                <div><h4 class="page-title" style="color: Orange">&nbsp; List of Tools Under Repair</h4></div><br>
                  <div class="table-responsive">
                    <table id="personnel_table" class="table table-bordered" style="width:100%">
                    <thead>
                        <tr>
                          <th style="width:5%"><center><input type="checkbox" id="checkboxall"></center></th>
                          <th>Tool Code</th>
                          <th style="max-width: 300px;">Description</th>
                          <th><center>Project</center></th>
                          <th><center>Date Repair</center></th>
                          <th style="max-width: 200px;"><center>Remarks</center></th>
                        </tr>
                    </thead>
                    <tbody id="listUnderRepair">
                      <?php
                        $get = $asset->get_asset_under_repair();
                        while($row = $get->fetch(PDO::FETCH_ASSOC))
                        {
                          //check the date if null
                          $date1 = $row['date_repair'];
                          if($date1 == ''){
                            $date1 = '-';
                          }else{
                            $date1 = date('F j, Y', strtotime($row['date_repair']));
                          }
                          
                          echo '
                          <tr>
                              <td><input type="checkbox" name="checklist" class="checklist" value="'.$row['asset_id'].'"></td>
                              <td>'.$row['code'].'</td>
                              <td style="max-width: 300px;">'.$row['description'].'</td>
                              <td><center>'.$row['location'].'</center></td>
                              <td><center>'.$date1.'</center></td>
                              <td style="max-width: 200px;">'.$row['repair_remark'].'</td>
                            </tr>';
                        }
                      ?>
                    </tbody>
                    </table>
                  </div>
                </div>
                <!-- Tools Repair History -->
                <div class="tab-pane" id="repairHistoryTabPanel" role="tabpanel"><br>
                  <div><h4 class="page-title" style="color: green">&nbsp; List of Tools Repair History</h4></div><br>
                    <div class="table-responsive">
                      <table id="personnel_table" class="table table-bordered" style="width:100%">
                      <thead>
                          <tr>
                            <th>Tool Code</th>
                            <th style="max-width: 200px;">Description</th>
                            <th>Project</th>
                            <th>Date Repair</th>
                            <th>Date Returned</th>
                            <th style="max-width: 200px;">Remarks</th>
                          </tr>
                      </thead>
                      <tbody id="listRepaired">
                        <?php
                          $get = $repair->view_repair_history();
                          while($row = $get->fetch(PDO::FETCH_ASSOC))
                          {
                            //check the date if null
                            $date1 = $row['date_repair'];
                            $date2 = $row['date_returned'];
                            if($date1 == ''){
                              $date1 = '-';
                            }else{
                              $date1 = date('F j, Y', strtotime($row['date_repair']));
                            }
                            if($date2 == ''){
                              $date2 = '-';
                            }else{
                              $date2 = date('F j, Y', strtotime($row['date_returned']));
                            } 
                            
                            echo '
                              <tr>
                                <td>'.$row['code'].'</td>
                                <td style="max-width: 200px;">'.$row['description'].'</td>
                                <td><center>'.$row['location'].'</center></td>
                                <td><center>'.$date1.'</center></td>
                                <td><center>'.$date2.'</center></td>
                                <td style="max-width: 200px;">'.$row['remarks'].'</td>
                              </tr>';
                          }
                        ?>
                      </tbody>
                      </table>
                    </div>
                  </div>          
              </div> <!-- end of tab-pane -->
            </div> <!-- end of card-body -->
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
<!-- NEW PERSONNEL/CLIENT MODAL -->
<div class="modal fade" id="updConditionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><span class="fa fa-plus-square"></span> Mark T&E Condition</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="tool-condition" class="modal-body">
        <!-- body goes here -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button id="btnSave" type="button" class="btn btn-primary">Save</button>
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
  <!-- End custom js for this page-->

  <!-- call the functions of plugin  -->
<script>
$(document).ready(function(){
  $('.js-example-basic-single').select2();
})
</script>

<!-- Mark the T&E Condition -->
<script>
$('#btnMark').click(function(e){
  e.preventDefault();
  var id = [];
  $('input:checkbox[name=checklist]:checked').each(function(){
    id.push($(this).val());
  })
  var myData = 'id=' + id;
  if(id == '')
  {
    $('#updConditionModal').modal('show');
    $('#tool-condition').html('<center><label style="color:red">Please select a tool to proceed.</label></center>');
    $('#btnSave').attr('disabled', true);
  }
  else
  {
    $.ajax({
      type: 'POST',
      url: '../../controls/view_condition.php',
      data: myData,
      success: function(html)
      {
        $('#updConditionModal').modal('show');
        $('#tool-condition').html(html);
        $('#btnSave').attr('disabled', false);
      },
      error: function(xhr, ajaxOptions, thrownError)
      {
        alert(thrownError);
      }
    })
  }  
})

// save tool condition
$('#btnSave').on('click', function(e){
  e.preventDefault();

  var id = $('#id').val();
  var condition = $('#condition').val();
  var remarks = $('#remarks').val();
  var myData = 'id=' + id + '&condition=' + condition + '&remarks=' + remarks;

  if(condition != null)
  {
    $.ajax({
      type: 'POST',
      url: '../../controls/save_condition.php',
      data: myData,
      success: function(response)
      {
        if(response > 0)
        {
          $('#upd-success').html("<center><i class='fa fa-check menu-icon'></i> T&E condition successfully updated.</center>");
          $('#upd-success').show();
            //get the latest list for repair
            $.ajax({
              url: '../../controls/view_repair_list.php',
              success: function(html)
              {
                $('#listForRepairs').fadeOut();
                $('#listForRepairs').fadeIn();
                $('#listForRepairs').html(html);
              }
            })
            //get the latest list under repair
            $.ajax({
              url: '../../controls/view_under_repair.php',
              success: function(html)
              {
                $('#listUnderRepair').fadeOut();
                $('#listUnderRepair').fadeIn();
                $('#listUnderRepair').html(html);
              }
            })
            //get the latest list for repair
            $.ajax({
              url: '../../controls/view_repair_tools.php',
              success: function(html)
              {
                $('#listRepaired').fadeOut();
                $('#listRepaired').fadeIn();
                $('#listRepaired').html(html);
              }
            })

          setTimeout(function(){
            $('#upd-success').fadeOut();
          }, 3000)
        }
        else
        {
          $('#upd-warning').html("<center><i class='fa fa-warning menu-icon'></i> Update Failed. Please contact the system administrator.</center>");
          $('#upd-warning').show();

          setTimeout(function(){
            $('#upd-warning').fadeOut();
          }, 3000)
        }
      }
    })
  }
  else
  {
    $('#upd-warning').html("<center><i class='fa fa-warning menu-icon'></i> Update Failed. Please fill out the data needed.</center>");
    $('#upd-warning').show();
    setTimeout(function(){
      $('#upd-warning').fadeOut();
    }, 3000)
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


<!--ADD-USER Auto Generate username based in input details -->
<script>
$('#lname').blur(function(e){
  e.preventDefault();

  var str = $('#fname').val();
  var fname = str.replace(/\s/g,'');
  var f = fname.toLowerCase();
  var str1 = $('#lname').val();
  var lname = str1.replace(/\s/g,'');
  var l = lname.toLowerCase();
  var username = f.concat('.').concat(l);
  $('#username').val(username);
})

$('#fname').blur(function(e){
  e.preventDefault();

  var str = $('#fname').val();
  var fname = str.replace(/\s/g,'');
  var f = fname.toLowerCase();
  var str1 = $('#lname').val();
  var lname = str1.replace(/\s/g,'');
  var l = lname.toLowerCase();
  var username = f.concat('.').concat(l);
  $('#username').val(username);
})
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
        $('#btndelete').show();
        $('.delete-user').hide();
        $('.edit-user').hide();
      }
      else
      {
        $('#btndelete').hide();
        $('.delete-user').show();
        $('.edit-user').show();
      }
    });
  }
  else
  {
    $('tbody tr td input[type="checkbox"]').each(function(){
      $(this).prop('checked', false);
      $('.edit-user').show();
      $('.delete-user').show();
      $('#btndelete').hide();
    });
  }
});

//checklist functions
$(document).on('change', '.checklist', function(){
  $('.checklist:checkbox').prop('checked', false);
  $(this).prop('checked', true);
});
</script>

<!-- BOOTSTRAP TABLE FUNCTION -->
<script>
  $(function(){
    $('.table').DataTable()({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    });
  });
</script>
</body>
</html>