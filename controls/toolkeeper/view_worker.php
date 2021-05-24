<?php
session_start();
include '../../config/clsConnection.php';
include '../../objects/clsWorker.php';

$database = new clsConnection();
$db = $database->connect();

$worker = new Worker($db);

$worker->project = $_SESSION['project-id'];
$view = $worker->view_worker();
while($row = $view->fetch(PDO::FETCH_ASSOC))
{
  echo '
  <tr>
    <td><input type="checkbox" name="checklist" class="checklist" value="'.$row['work-id'].'" style="max-width: 30px;"></td>
    <td>'.$row['worker_id'].'</td>
    <td>'.$row['fullname'].'</td>
    <td>'.$row['position'].'</td>
    <td><center>'.$row['trade_name'].'</center></td>
    <td><center>'.$row['proj_name'].'</center></td>
    <td style="width:20%"><center><a class="edit-worker" href="#" value="'.$row['work-id'].'" data-toggle="modal"><i class="fa fa-edit text-green"></i> Edit |</a> <a class="delete-worker" href="#" value="'.$row['work-id'].'" data-toggle="modal"><i class="fa fa-trash"></i> Delete</a></center></td>
  </tr>';
}
?>
<script>
//delete Worker
$('.delete-worker').on('click', function(e){
  e.preventDefault();
   var id = $(this).attr('value');

  if(confirm('WARNING! Are you sure you want to remove this user in the list?'))
  {
    $.ajax({
      type: 'POST',
      url: '../../controls/toolkeeper/delete_worker.php',
      data: {id: id},
      success: function(response)
      { 
        if(response > 0)
        {
        //get the new list of worker
        $.ajax({
            type: 'POST',
            url: '../../controls/toolkeeper/view_worker.php',

            success: function(html)
            {
              $('#worker-body').fadeOut();
              $('#worker-body').fadeIn();
              $('#worker-body').html(html);
            }
          })
        }
        else
        {
          alert('Delete Failed. Please contact the system administrator at local 124 for assistance.');
        }
      }
    })
  }
})

//Delete multiple Worker 
$('#btndelete').on('click', function(e){
  e.preventDefault();

  var id = [];
  $('input:checkbox[name=checklist]:checked').each(function(){
    id.push($(this).val())
  });

  if(confirm('WARNING! Are you sure you want to remove this user in the list?'))
  {
    $.each(id, function(key, value){
      $.ajax({
        type: 'POST',
        url: '../../controls/toolkeeper/delete_worker.php',
        data: {id: value},
        success: function(response)
        { 
          if(response > 0)
          {
          //get the new list of worker
          $.ajax({
              type: 'POST',
              url: '../../controls/toolkeeper/view_worker.php',
              success: function(html)
              {
                $('#worker-body').fadeOut();
                $('#worker-body').fadeIn();
                $('#worker-body').html(html);
              }
            })
          }
          else
          {
            alert('Delete Failed. Please contact the system administrator at local 124 for assistance.');
          }
        }
      })
    })
  }
})
</script>