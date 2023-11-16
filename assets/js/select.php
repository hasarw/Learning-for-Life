<?php


     $output = "";

     $connect = new mysqli('localhost', 'root', 'Google22!', 'wvi-db');

    
    $query = "select * from tbl_media_photos order by photo_id desc";

    $result = mysqli_query($connect, $query);
    while($row = mysqli_fetch_array($result))
    {
     $output[] = $row;
    }





?>