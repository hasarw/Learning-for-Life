<?php

require_once "../includes/function.php";
require_once "../db.php";
require_once "../query_functions.php";

$functions = new query_functions();

$data = json_decode(file_get_contents("php://input"));

$target= $data->target;
$achivemnt= $data->achievement;
$act_id = $data->act_id;


/// Function to insert to database ////////////////////

$functions->insert_new_itt($target,$achivemnt,$act_id);

?>