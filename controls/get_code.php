<?php
include '../config/clsConnection.php';
include '../objects/clsType.php';
include '../objects/clsLocation.php';
include '../objects/clsLogs.php';

$database = new clsConnection();
$db = $database->connect();

$type = new Type($db);
$location = new Location($db);
$log = new Logs($db);

//initialize data
$loc_id = $_POST['proj'];
$type_id = $_POST['cat'];
$proj_code = '';

//get the code of project/building(location)
$location->id = $loc_id;
$get_proj = $location->get_location_name();
while($row = $get_proj->fetch(PDO::FETCH_ASSOC))
{	
	$proj_code = $row['code'];
}

//get the series no
$log->loc_id = $loc_id;
$log->type_id = $type_id;
$get_series = $log->get_series();
while($row = $get_series->fetch(PDO::FETCH_ASSOC))
{
	$series_no = $row['series_no'];
}

//return the data gathered
if(!$proj_code && !$series_no)
{
	echo json_encode(0);
}
else
{	
	$array = array($proj_code, intval($series_no));
	echo json_encode($array);
}
?>