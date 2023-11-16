
<?php

require_once "/includes/config.php";

// Create connection
    session_start();

    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
    $update_title = $request->update_title;
    $update_desc = $request->update_desc;
    $update_user = $_SESSION['member_id'];
    echo $email;

    date_default_timezone_set("Asia/kabul");
    $date = date("Y-m-d h:i:s");

require_once "db.php";
$conn = new mysqli(HOST, USER, PASSWORD, DATABASE);

$sql = "INSERT INTO `tbl_update` (`update_id`, `update_title`, `update_desc`, `update_user`,`update_date`, `update_status`)
VALUES (null, '$update_title', '$update_desc', '$update_user', '$date', 1)";

if ($conn->query($sql) === TRUE) {
    echo "<script>window.location = 'Report.php';</script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
