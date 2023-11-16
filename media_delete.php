<?php
	
require_once "/includes/function.php";
require_once "db.php";
require_once "query_functions.php";




$functions = new query_functions();

	

    $data = json_decode(file_get_contents("php://input"));

    $photo_id = $data->id;

    $photo_name = $data->filename;

    $functions->deleteMedia($photo_id);
    $functions->getPhotos();

    unlink('media/'."$photo_name");

?>