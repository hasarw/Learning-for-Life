<?php

require_once "/includes/function.php";
require_once "db.php";
require_once "query_functions.php";

$functions = new query_functions();



if (isset($_POST['submit'])) {
  
  $slide_title = $_POST['media_title'];
  $slide_desc = $_POST['media_desc'];

$target_dir = "media/slider/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image

    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    } 

    $slide_add = "1";

  $functions->insertSlide($slide_title, $slide_desc, $target_file);

  $data = $functions->getSlides();


  header("Location: slider.php");


}

?>