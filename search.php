<?php
// The request is a JSON request.
// We must read the input.
// $_POST or $_GET will not work!
require_once "/includes/config.php";

$conn = new mysqli(HOST, USER, PASSWORD, DATABASE);


$data = file_get_contents("php://input");

$objData = json_decode($data);
$objid = json_decode($id);

$password =  $objData->data;
$member_id =  $objData->id;

$query = "SELECT `member_password` from tbl_members WHERE `member_id` = '$member_id'";

$result = $conn->query($query);

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
      $member_password = $row['member_password'];
  }
}
$conn->close();


// Static array for this demo
// $values = array('php', 'web', 'angularjs', 'js');

// Check if the keywords are in our array
if($member_password == $password){
  echo "Correct Password!";
}else{
  echo "Incorrect Password!";
}


?>
