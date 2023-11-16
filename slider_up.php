<?php
	
require_once "/includes/function.php";
require_once "db.php";
require_once "query_functions.php";

$functions = new query_functions();

    $data = json_decode(file_get_contents("php://input"));

    $slide_id = $data->slide__id;
    $slide_num = $data->slide__num;

    $functions->updateSlide($slide_id,$slide_num);

    // unlink('media/'."$photo_name");

?>