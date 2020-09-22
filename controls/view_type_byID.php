<?php
include '../config/clsConnection.php';
include '../objects/clsType.php';

$database = new clsConnection();
$db = $database->connect();

$type = new Type($db);

  $type->id = $_POST['id'];
  $view = $type->view_type_byid();

  while($row = $view->fetch(PDO::FETCH_ASSOC))
  {
    extract($row);
    echo '
      <div class="form-group">
          <div class="row">
            <div class="col-lg-3">
              <label for="exampleInputEmail1">T&E Category Name</label>
            </div>
            <div class="col-lg-9">
              <input type="text" class="form-control" id="upd_id" value="'.$row['id'].'" hidden>
              <input type="text" class="form-control" id="upd_type" value="'.$row['type'].'">
            </div>
          </div><br>
           <div class="row">
            <div class="col-lg-3">
              <label for="exampleInputEmail1">Description</label>
            </div>
            <div class="col-lg-9">
              <textarea type="text" class="form-control" id="upd_desc" placeholder="Enter Category Description" rows="4">'.$row['description'].'</textarea>
            </div>
          </div>
      </div>';
  }

?>