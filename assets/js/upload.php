<?php


     require_once "includes/function.php";
     require_once "db.php";
     require_once "query_functions.php";

     $functions = new query_functions();

     $target_dir = "./media/";

     $target_file = $target_dir . basename($_FILES["file"]["name"]);

     move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);

     // write code for saving to database 

      $functions->insertMediaPhotos('sdasd', basename($_FILES["file"]["name"]), 'ss');

?>