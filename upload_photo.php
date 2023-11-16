<?php


     require_once "includes/function.php";
     require_once "db.php";
     require_once "query_functions.php";

     $functions = new query_functions();

     $target_dir = "./media/";

     print_r($_FILES);

     $target_file = $target_dir . basename($_FILES["file"]["name"]);

     move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);

     // write code for saving to database 

      $functions->insertMediaPhotos('sds', basename($_FILES["file"]["name"]), 'asdas');

?>