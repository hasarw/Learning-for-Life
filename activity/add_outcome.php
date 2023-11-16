<?php

require_once "../includes/function.php";
require_once "../db.php";
require_once "../query_functions.php";

$functions = new query_functions();

$data = json_decode(file_get_contents("php://input"));

$title=$data->name;

////////////////////////////////////////////


$functions->insert_new_outcome($title);


?>