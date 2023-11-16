<?php

     require_once "/includes/function.php";
     require_once "db.php";
     require_once "query_functions.php";

     $functions = new query_functions();


	if(isset($_POST['submit_image']))
	{
	for($i=0;$i<count($_FILES["upload_file"]["name"]);$i++)
	{
	 $uploadfile=$_FILES["upload_file"]["tmp_name"][$i];
	 $folder="media/";


	 $path_parts = pathinfo($_FILES["upload_file"]["name"][$i]);


     $ext = $path_parts['extension'];
     $name = $path_parts['filename'];

     $name = md5($name);
     $last_id = $functions->get_last_photo();
     $file_upload = $last_id."".$name.".".$ext;

	 move_uploaded_file($_FILES["upload_file"]["tmp_name"][$i], "$folder".$file_upload);

	$album_id = $_POST['album_id'];
	$functions->insertMediaPhotos($album_id, basename($_FILES["upload_file"]["name"][$i]), $desc);

	$functions->getPhotos();

	}
	exit();
	}

?>