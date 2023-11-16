<?php

require_once "/includes/function.php";
require_once "db.php";
require_once "query_functions.php";


$functions = new query_functions();

$data = json_decode(file_get_contents("php://input"));

$activity_id=$conn->real_escape_string($data->id);
$activity_end_date=$conn->real_escape_string($data->spend);

$functions->UpdateActivityEndDate($activity_id, $activity_end_date);


?>