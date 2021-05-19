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
            <div class="col-lg-12">
              <h4><b>PROJECT: <u> <?php echo $_SESSION['proj-name']; ?></u></b></h4>  
              <div class="card">
                <div class="card-body">
                  <table id="asset_table" class="table table-bordered table-hover" style="cursor:pointer">
                    <thead>
                        <tr>
                            <th style="width: 10px;"><input type="checkbox" id="checkboxall"/></th>
                            <th>T&E Code</th>
                            <th>Description</th>
                            <th>Category</th>
                            <th>Trade</th>
                            <th><center>Status</center></th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php
                        $asset->project = $_SESSION['project-id'];
                        $view = $asset->get_asset_byProj();

                        while($row = $view->fetch(PDO::FETCH_ASSOC))
                        {
                          if($row['status'] == 1){
                            $status = '<label style="color: green"> In Storage </label>';
                          }
                          elseif($row['status'] == 2){
                            $status = '<label style="color: green"> Returned </label>';
                          }else{
                            $status = '<label style="color: red"> Borrowed </label>';
                          }
                          echo '
                            <tr>
                              <td><input type="checkbox" name="checklist" class="checklist" value="'.$row['asset_id'].'" style="max-width: 50px;"></td>
                              <td>'.$row['code'].'</td>
                              <td>'.$row['description'].'</td>
                              <td>'.$row['cat_name'].'</td>
                              <td>'.$row['dept_name'].'</td>
                              <td><center>'.$status.'</center></td>
                            </tr>';
                        }
                      ?>
                    </tbody>
                  </table>
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
      //alert(response);
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