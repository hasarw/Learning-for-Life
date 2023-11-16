<?php
     require_once "query_functions.php";
     $functions = new query_functions();

     session_start();

     $random = $functions -> countUpload();

     date_default_timezone_set("Asia/kabul");
     $date = date("Y-m-d");

     $target_dir = "./upload/";
     $name = $_POST['name'];
     $desc = $_POST['desc'];

     //$target_file = $target_dir . basename($_FILES["file"]["name"]);

    //  $finfo = finfo_open(FILEINFO_MIME_TYPE);
    //  $mime = finfo_file($finfo, $_FILES["file"]["name"]);

     $temp = explode(".", $_FILES["file"]["name"]);
     $newfilename = $random . '.' . end($temp);
     move_uploaded_file($_FILES["file"]["tmp_name"], "./upload/" . $newfilename);

    //if($mime == 'application/pdf'){
     //move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
   //}
    // Write code for saving to database
    require_once "/includes/config.php";

    // Create connection
    $conn = new mysqli(HOST, USER, PASSWORD, DATABASE);
    $user_id = $_SESSION['member_id'];
    $sql = "INSERT INTO `tbl_report` (`report_user_id`, `report_title`, `report_desc`, `report_upload_file`, `report_date`) VALUES ($user_id, '$name', '$desc', '$newfilename', '$date')";

     if ($conn->query($sql) === TRUE) {
         header ("location: report.php");
     } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
     }

     $conn->close();

?>
