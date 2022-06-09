<?php
include '../config/clsConnection.php';
include '../objects/clsAsset.php';

$database = new clsConnection();
$db = $database->connect();

$asset = new Asset($db);

	//uploading the attached image
	$file = $_FILES['files']['name'];
	$path = '/usr/share/amstool/uploads/'.$file;
	//$path = '/wamp64/www/tems/uploads/'.$file;
	$temp = $_FILES['files']['tmp_name'];
	$name = $_FILES['files']['name'];
	$uploadStat = 1;

	//if file is ready for upload
	if($uploadStat == 1)
	{
		if(move_uploaded_file($temp, $path))
		{
			//check if asset is newly added (action = 1)
			if($_POST['action'] == 1)
			{
				$id = "";
				$get_id = $asset->get_last_id();
				while($row = $get_id->fetch(PDO::FETCH_ASSOC))
				{
					$id = $row['asset_id'];
				}

				$asset->image = "../../uploads/".$file;
				$asset->id = $id;
				$save = $asset->insert_image();

				if($save)//update the database 
				{
					echo $id;
				}
				else
				{
					echo 0;
				}
			}
			else//if asset is for Update(action = 2)
			{
				$id = $_GET['id'];
				$asset->image = "../../uploads/".$file;
				$asset->id = $id;
				$upd = $asset->upd_image();

				if($upd)//update the database 
				{
					echo 1;
				}
				else
				{
					echo 0;
				}
			}
			
		}
	}

?>