<?php


     $output = "";

     $connect = new mysqli('localhost', 'root', 'Google22!', 'wvi-db');

    
    $query = "select photo_add from tbl_media_photos order by photo_id desc";

    $result = mysqli_query($connect, $query);
    while($row = mysqli_fetch_array($result))
    {
     $output[] = $row;
    }


     $fp = fopen('mediaPhotosAddress.json', 'w');
        fwrite($fp, json_encode($rows, JSON_UNESCAPED_UNICODE ));
        fclose($fp);
        
    // echo json_encode($output, JSON_UNESCAPED_UNICODE);

    // fwrite($fp, json_encode($rows, JSON_UNESCAPED_UNICODE ));





?>