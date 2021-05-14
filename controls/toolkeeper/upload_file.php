<?php
include '../../config/clsConnection.php';
include '../../objects/clsWorker.php';

$database = new clsConnection();
$db = $database->connect();

$worker = new Worker($db);

$filename = $_FILES['files']['tmp_name'];
if($_FILES['files']['size'] > 0)
{
	$file = fopen($filename, "r");
	$count = 0;

	while(($data = fgetcsv($file, 10000, ",")) !== FALSE)
	{
		$count ++;
		if($count > 1)
		{
			$worker->worker_id = $data[0];
			$worker->fullname = $data[1];
			$worker->position = $data[2];
			$worker->trade = $data[3];
			$worker->project = $data[4];
			$worker->status = 1;

			$save = $worker->save_worker();

			if($save)
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
else
{
	echo 'Upload Failed. Please contact the system administrator.';
}

?>