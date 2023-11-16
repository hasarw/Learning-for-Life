<?php

require_once "/includes/config.php";
session_start();

class query_functions {

    function countBeneficiary($place, $place_names) {
    $conn = new mysqli(HOST, USER, PASSWORD, DATABASE);

    $sql = "select COUNT(beneficiary_id) as beneficiary_count from tbl_beneficiary where `$place` IN ($place_names)";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
          $beneficiary_count = $row['beneficiary_count'];
      }
    }
    
    $conn->close();
    return $beneficiary_count;
    }


    function countVillages($place) {
    $conn = new mysqli(HOST, USER, PASSWORD, DATABASE);

    $beneficiary_total = array();

    $sql = "SELECT `beneficiary_village`,COUNT(*) as total FROM tbl_beneficiary where `beneficiary_district` = '$place' GROUP BY `beneficiary_village`;";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {

      while($row = $result->fetch_assoc()) {
            $beneficiary_total[] = $row;
      }
    }
    $conn->close();
    return $beneficiary_total;
    }


    function getGender($place) {
    $conn = new mysqli(HOST, USER, PASSWORD, DATABASE);

    $gender_total = array();

    $sql = "SELECT `beneficiary_gender`,COUNT(*) as genderCount FROM tbl_beneficiary where `beneficiary_district` = '$place' GROUP BY `beneficiary_gender`;";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {

      while($row = $result->fetch_assoc()) {
            $gender_total[] = $row;
      }
    }
    $conn->close();
    return $gender_total;
    }





function getBenf(){
  $conn = new mysqli(HOST, USER, PASSWORD, DATABASE);
$sql = "SELECT tbl_benf.benf_code, tbl_benf.benf_survey_code, tbl_benf.benf_HH_code, tbl_benf.benf_name, tbl_benf.benf_age, tbl_benf.benf_gender, tbl_benf.benf_phone_number, tbl_benf.benf_type, tbl_benf.benf_status, tbl_district.district_name, tbl_village.village_name
FROM `tbl_benf`
LEFT JOIN tbl_district
ON tbl_benf.benf_district = tbl_district.district_id
LEFT JOIN tbl_village
on tbl_benf.benf_village = tbl_village.village_id
GROUP BY tbl_benf.benf_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {

        $rows = array();
        while($r = mysqli_fetch_assoc($result)) {
            $rows[] = $r;
        }

        $fp = fopen('benf.json', 'w');
        fwrite($fp, json_encode($rows, JSON_UNESCAPED_UNICODE ));
        fclose($fp);

        $conn->close();
      }
}


function listOptions($question_code){
$conn = new mysqli(HOST, USER, PASSWORD, DATABASE);

$sql = "SELECT answer_desc FROM `tbl_answer` WHERE `answer_question_code` = '$question_code'";
$result = $conn->query($sql);
$options = array();
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $options[] = $row;
  }
}
return $options;
}


function getResult($getArray){
$conn = new mysqli(HOST, USER, PASSWORD, DATABASE);

$a = array();
$a = $getArray;
//get the array and convert it to string statement
foreach ($a as $key) {
  $str .= "tbl_benf_answers."."`".$key['answer_code']."`,";
}
return $str;
}



function createChart($getArray){

$a = array();
$a = $getArray;
$count = 1;
//get the array and convert it to string statement
$str = "SELECT ";
foreach ($a as $key) {
  $str .= "count(case when `".$key['answer_code']."` = 1 then `".$key['answer_code']."` end) as col_".$count." ,";
  $count++;
}
$str=rtrim($str,",");
$str .= "from tbl_benf_answers;";

return $str;

}



function chartData($query){
$conn = new mysqli(HOST, USER, PASSWORD, DATABASE);

$result = $conn->query($query);
$options = array();
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $data[] = $row;
  }
}
return $data;
}




function GetPassword($user_id){
$conn = new mysqli(HOST, USER, PASSWORD, DATABASE);

$sql = "SELECT `member_password` FROM `tbl_members` WHERE `member_id` = '$user_id'";
$result = $conn->query($sql);
$options = array();
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $password = $row['member_password'];
  }
}
$conn->close();
return $password;
}



function SetPassword($password, $member_id){
$conn = new mysqli(HOST, USER, PASSWORD, DATABASE);

$hashed_password = sha1($password);


$sql = "UPDATE `tbl_members` SET `member_password`= '$hashed_password' WHERE `member_id` = '$member_id'";
if ($conn->query($sql) === TRUE) {
    return true;
}else{
  return false;
}
$conn->close();
}



function countUpload() {
$conn = new mysqli(HOST, USER, PASSWORD, DATABASE);

$sql = "SELECT COUNT(report_id) as countReport FROM `tbl_report`";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
      $count = $row['countReport'];
  }
}
$conn->close();
return $count;
}



function getUpdates() {
$conn = new mysqli(HOST, USER, PASSWORD, DATABASE);

$updates = array();

$sql = "SELECT tbl_update.`update_id`, tbl_update.`update_title`, tbl_update.`update_desc`, tbl_update.`update_date`,tbl_members.member_name FROM `tbl_update`, tbl_members WHERE tbl_update.`update_status` = 1 AND tbl_members.member_id = tbl_update.update_user ORDER BY tbl_update.`update_date` DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {

  while($row = $result->fetch_assoc()) {
        $updates[] = $row;
  }
}
$conn->close();
return $updates;
}


function SetUpdate($id, $title, $desc){
$conn = new mysqli(HOST, USER, PASSWORD, DATABASE);

$sql = "UPDATE `tbl_update` SET `update_title` = '$title', `update_desc` = '$desc' WHERE `update_id` = $id";
if ($conn->query($sql) === TRUE) {
    return true;
}else{
  return false;
}
$conn->close();
}

function deleteUpdate($id){
$conn = new mysqli(HOST, USER, PASSWORD, DATABASE);

$sql = "DELETE FROM `tbl_update` WHERE `update_id` = $id";
if ($conn->query($sql) === TRUE) {
    return true;
}else{
  return false;
}
$conn->close();
}


function deleteReport($id, $file){
$conn = new mysqli(HOST, USER, PASSWORD, DATABASE);

$sql = "DELETE FROM `tbl_report` WHERE `report_id` = $id";
if ($conn->query($sql) === TRUE) {
    unlink('upload/'.$file);
    return true;
}else{
  return false;
}
$conn->close();
}




function get_sub_activity($activity_id){
$conn = new mysqli(HOST, USER, PASSWORD, DATABASE);

$sql = "SELECT `sub_activity_id`,`sub_activity_start_date`,`sub_activity_end_date`, `sub_activity_cost`,`sub_activity_desc`,`sub_activity_percent`
FROM `tbl_sub_activity_details`
WHERE `sub_activity_main_id` = $activity_id order by `sub_activity_main_id`";

$result = $conn->query($sql);
$array = array();
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $array[] = $row;

    }
  }

  $conn->close();

  return $array;
}


function get_sub_activity_details(){
$conn = new mysqli(HOST, USER, PASSWORD, DATABASE);

$sql = "SELECT tbl_activity.activity_id, tbl_activity.activity_name, tbl_activity.activity_table_id, 
tbl_sub_activity_details.sub_activity_id, tbl_sub_activity_details.sub_activity_main_id, tbl_sub_activity_details.sub_activity_name, tbl_sub_activity_details.sub_activity_start_date, tbl_sub_activity_details.sub_activity_end_date, tbl_sub_activity_details.sub_activity_main_id FROM tbl_activity
LEFT JOIN tbl_sub_activity_details
ON tbl_activity.activity_table_id = tbl_sub_activity_details.sub_activity_main_id
ORDER BY tbl_activity.activity_table_id";

$result = $conn->query($sql);
$array = array();
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $array[] = $row;

    }
  }

  $conn->close();

  return $array;
}

function get_baseline_activity($base_line, $start_date){

    $date1 = $base_line;
    $date2 = $start_date;

    $ts1 = strtotime($date1);
    $ts2 = strtotime($date2);

    $year1 = date('Y', $ts1);
    $year2 = date('Y', $ts2);

    $month1 = date('m', $ts1);
    $month2 = date('m', $ts2);

    $diff = (($year2 - $year1) * 12) + ($month2 - $month1);

    return $diff;
}



function count_activity($activity_id){
$conn = new mysqli(HOST, USER, PASSWORD, DATABASE);

$sql = "SELECT count(sub_activity_main_id) as total FROM tbl_sub_activity WHERE `sub_activity_main_id` = $activity_id";

$result = $conn->query($sql);
$count = 1;

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {

    $count = $row['total'];

    }
  }
  $conn->close();

  return $count;

}


function get_sub_activity_period($activity_id){
$conn = new mysqli(HOST, USER, PASSWORD, DATABASE);

$sql = "SELECT `sub_activity_start_date`,`sub_activity_end_date`,`sub_activity_desc` FROM `tbl_sub_activity` WHERE `sub_activity_main_id` = $activity_id";
$result = $conn->query($sql);
$count = 1;

//
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {

    // What I want from this function?
    // I send the end date to this function, it should calculate the time for
    // start the new activity

    $sub_activity_start_date = $row['sub_activity_start_date'];
    $sub_activity_end_date = $row['sub_activity_end_date'];

    $sub_activity_desc = $row['sub_activity_desc'];

    $ts1 = strtotime($sub_activity_start_date);
    $ts2 = strtotime($sub_activity_end_date);

    $year1 = date('Y', $ts1);
    $year2 = date('Y', $ts2);

    $month1 = date('m', $ts1);
    $month2 = date('m', $ts2);

    $diff = (($year2 - $year1) * 12) + ($month2 - $month1);


    $baseDate = strtotime($end_date);
    $yearBase = date('Y', $baseDate);
    $monthbase = date('m', $baseDate);
    $diffBase = (($year1 - $yearBase) * 12) + ($month1 - $monthbase);


    }
  }
  $conn->close();

  return $diffBase;
}

function SetUpdateActivity($id, $title){
$conn = new mysqli(HOST, USER, PASSWORD, DATABASE);

$sql = "UPDATE `tbl_sub_activity_details` SET `sub_activity_percent` = '$title' WHERE `sub_activity_id` = $id";
if ($conn->query($sql) === TRUE) {
    return true;
}else{
  return false;
}
$conn->close();
}

//////////////////// GLOSSARY //////////////////////////////////////////////////

function selectGlossary(){

$conn = new mysqli(HOST, USER, PASSWORD, DATABASE);

$sql = "SELECT `glossary_id`, `glossary_key`, `glossary_def`, `glossary_status` FROM `tbl_glossary` ORDER BY `glossary_key`";

$result = $conn->query($sql);

if ($result->num_rows > 0) {

        $rows = array();
        while($r = mysqli_fetch_assoc($result)) {
            $rows[] = $r;
        }

        $fp = fopen('json/glossary.json', 'w');
        fwrite($fp, json_encode($rows, JSON_UNESCAPED_UNICODE ));
        fclose($fp);
        
        $conn->close();
      }
}

//////////////////////////////////////////////////////////////////////////////

function deleteGlossary($id){
$conn = new mysqli(HOST, USER, PASSWORD, DATABASE);

$sql = "DELETE FROM `tbl_glossary` WHERE `glossary_id` = $id";
if ($conn->query($sql) === TRUE) {
    return true;
}else{
  return false;
}
$conn->close();
}

//////////////////////////////////////////////////////////////////////////////////


function getAllTask(){

$conn = new mysqli(HOST, USER, PASSWORD, DATABASE);

$sql = "SELECT `task_id`, `task_title`, `task_desc`, `task_issue_date`, `task_due_date`, `task_owner`, `task_implementer`, `task_priority`, `Task_status` FROM `tbl_task` WHERE 1";

$result = $conn->query($sql);

if ($result->num_rows > 0) {

        $rows = array();
        while($r = mysqli_fetch_assoc($result)) {
            $rows[] = $r;
        }

        $fp = fopen('task.json', 'w');
        fwrite($fp, json_encode($rows, JSON_UNESCAPED_UNICODE ));
        fclose($fp);
        
        $conn->close();
      }

}



function getMedia(){

$conn = new mysqli(HOST, USER, PASSWORD, DATABASE);

$sql = "SELECT `media_id`, `media_title`, `media_desc`, `media_add`, `media_name`, `media_type`, `media_date`, `media_owner`, `media_status` FROM `tbl_media`";

$result = $conn->query($sql);

if ($result->num_rows > 0) {

        $rows = array();
        while($r = mysqli_fetch_assoc($result)) {
            $rows[] = $r;
        }

        $fp = fopen('mediaPhotos.json', 'w');
        fwrite($fp, json_encode($rows, JSON_UNESCAPED_UNICODE ));
        fclose($fp);
        
        $conn->close();
      }

}



function getPhotos(){

$conn = new mysqli(HOST, USER, PASSWORD, DATABASE);

$sql = "SELECT `photo_id`, `photo_media_id`, `photo_add`, `photo_desc` FROM `tbl_media_photos` WHERE 1";

$result = $conn->query($sql);

if ($result->num_rows > 0) {

        $rows = array();
        while($r = mysqli_fetch_assoc($result)) {
            $rows[] = $r;
        }

        $fp = fopen('mediaPhotosAddress.json', 'w');
        fwrite($fp, json_encode($rows, JSON_UNESCAPED_UNICODE ));
        fclose($fp);
        
        $conn->close();
      }


}

// Slider functions -> select / update / delete functions ///////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////

function getSlides(){

$conn = new mysqli(HOST, USER, PASSWORD, DATABASE);

$sql = "SELECT `slide_id`, `slide_title`, `slide_desc`, `slide_address`, `slide_date`, `slide_num`, `slide_status` FROM `tbl_slider` ORDER by `slide_num` DESC";

$result = $conn->query($sql);

if ($result->num_rows > 0) {

        $rows = array();
        while($r = mysqli_fetch_assoc($result)) {
            $rows[] = $r;
        }

        $fp = fopen('mediaSlider.json', 'w');
        fwrite($fp, json_encode($rows, JSON_UNESCAPED_UNICODE ));
        fclose($fp);

        return $rows;
        
        $conn->close();
      }
}


function deleteSlide($slide_id){
$conn = new mysqli(HOST, USER, PASSWORD, DATABASE);

$sql = "DELETE FROM `tbl_slider` WHERE `slide_id` = '$slide_id'";

if ($conn->query($sql) === TRUE) {
    echo "Deleted.";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
}


function insertMedia($title, $desc, $type, $filename){
$conn = new mysqli(HOST, USER, PASSWORD, DATABASE);

    $owner = $_SESSION['member_id'];

  $sql = "INSERT INTO `tbl_media`(`media_id`, `media_title`, `media_desc`, `media_add`, `media_name`, `media_type`, `media_owner`, `media_status`) VALUES (null, '$title', '$desc', '$filename', '$name', $type, $owner, 1)";


if ($conn->query($sql) === TRUE) {
    echo "Inserted";
    $this->getSlides();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

}


//delete video query


function deleteVideo($video_id){
$conn = new mysqli(HOST, USER, PASSWORD, DATABASE);

  $sql = "DELETE FROM `tbl_media` WHERE `media_id` = '$video_id'";

if ($conn->query($sql) === TRUE) {
    echo "Deleted";
    
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

}


// End of slider functions here /////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////

function get_last_photo(){
$conn = new mysqli(HOST, USER, PASSWORD, DATABASE);

$sql = "SELECT `photo_id`FROM tbl_media_photos ORDER by photo_id DESC LIMIT 1";

$result = $conn->query($sql);
$count = 0;

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {

    $count = $row['photo_id'];

    }
  }
  $conn->close();

  return $count;

}




function insertMediaPhotos($album_id, $address, $desc){
$conn = new mysqli(HOST, USER, PASSWORD, DATABASE);

    $owner = $_SESSION['member_id'];

    $path_parts = pathinfo($address);


    $ext = $path_parts['extension'];
    $name = $path_parts['filename'];

    $lastId = $this->get_last_photo();

    $file_upload = $lastId."".md5($name).".".$ext;
   

  $sql = "INSERT INTO `tbl_media_photos`(`photo_id`, `photo_media_id`, `photo_add`, `photo_desc`) VALUES (null,'$album_id', '$file_upload', '$desc')";


if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

}



function deleteMedia($photo_id){
$conn = new mysqli(HOST, USER, PASSWORD, DATABASE);


  $sql = "DELETE FROM `tbl_media_photos` WHERE `photo_id` = '$photo_id'";


if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

}




function insertSlide($title, $desc, $address){
$conn = new mysqli(HOST, USER, PASSWORD, DATABASE);


    // $path_parts = pathinfo($address);


    // $ext = $path_parts['extension'];
    // $name = $path_parts['filename'];

    // $lastId = $this->get_last_photo();

    // $file_upload = $lastId."".md5($name).".".$ext;
   

  $sql = "INSERT INTO `tbl_slider`(`slide_id`, `slide_title`, `slide_desc`, `slide_address`, `slide_date`, `slide_num`, `slide_status`) VALUES (null, '$title', '$desc', '$address', '0000-00-00', 1, 1)";


if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

}



function updateSlide($slide_id, $slide_num){
$conn = new mysqli(HOST, USER, PASSWORD, DATABASE);

$slide_num += 1;


$sql = "UPDATE `tbl_slider` SET `slide_num`= '$slide_num' WHERE `slide_id` = '$slide_id'";
if ($conn->query($sql) === TRUE) {
    return true;
}else{
  return false;
}
$conn->close();
}



function get_percentage($question_id){
$conn = new mysqli(HOST, USER, PASSWORD, DATABASE);

$sql = "SELECT DISTINCT `$question_id` as theAns, COUNT(`$question_id`) as theCount FROM `tbl_benf_answers` group by `$question_id` order by theCount desc";

$result = $conn->query($sql);
$array = array();
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {

    $array[] = $row;

    }
  }

  $conn->close();

  return $array;
}



function getAllQuestion(){
$conn = new mysqli(HOST, USER, PASSWORD, DATABASE);

$sql = "SELECT `question_code` FROM `tbl_question`";

$result = $conn->query($sql);
$array = array();
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $array[] = $row;
    }
  }
  $conn->close();

  return $array;
}




function getTrackerActivity(){
    $conn = new mysqli(HOST, USER, PASSWORD, DATABASE);
    
    $sql = "SELECT tbl_sub_activity_details.sub_activity_id,
    tbl_activity.activity_name as act_name,
    tbl_activity.activity_id,
    tbl_sub_activity_details.sub_activity_start_date as startdate,
    tbl_sub_activity_details.sub_activity_end_date as enddate,
    tbl_sub_activity_details.sub_activity_cost,
    tbl_sub_activity_details.sub_activity_desc,
    tbl_sub_activity_details.sub_activity_percent,
    tbl_sub_activity_details.sub_activity_main_id
    FROM tbl_activity
    LEFT JOIN tbl_sub_activity_details
    ON tbl_activity.activity_table_id = tbl_sub_activity_details.sub_activity_main_id
    ORDER BY tbl_activity.activity_show_after";

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {

            $rows = array();
            while($r = mysqli_fetch_assoc($result)) {
                $rows[] = $r;
            }

            $fp = fopen('activities.json', 'w');
            fwrite($fp, json_encode($rows, JSON_UNESCAPED_UNICODE ));
            fclose($fp);

            $conn->close();
          }
}



/////////////////////////////////////////////

function getTrackerSubActivity(){
    $conn = new mysqli(HOST, USER, PASSWORD, DATABASE);
    
    $sql = "SELECT * FROM `tbl_sub_activity_details`";

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {

            $rows = array();
            while($r = mysqli_fetch_assoc($result)) {
                $rows[] = $r;
            }

            $fp = fopen('activitiesList.json', 'w');
            fwrite($fp, json_encode($rows, JSON_UNESCAPED_UNICODE ));
            fclose($fp);

            $conn->close();
          }
}



////////// GET ALL ACTIVITIES ///////////////

function getAllActivities(){
$conn = new mysqli(HOST, USER, PASSWORD, DATABASE);

$sql = "SELECT `activity_table_id`, `activity_id`, `activity_name`, `activity_base_date`, `activity_start_date`, `activity_end_date`, `activity_percent` FROM `tbl_activity` WHERE 1";

$result = $conn->query($sql);
$array = array();
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $array[] = $row;
    }
  }
  $conn->close();

  return $array;
}


///////////////////////////////////////////////


function getQuestions(){
    $conn = new mysqli(HOST, USER, PASSWORD, DATABASE);
    $sql = "SELECT `question_id`, `question_code`, `question_desc` FROM `tbl_question` WHERE 1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {

            $rows = array();
            while($r = mysqli_fetch_assoc($result)) {
                $rows[] = $r;
            }

            $fp = fopen('questions.json', 'w');
            fwrite($fp, json_encode($rows, JSON_UNESCAPED_UNICODE ));
            fclose($fp);

            $conn->close();
          }
}




function UpdateActivity($id, $data){
$conn = new mysqli(HOST, USER, PASSWORD, DATABASE);

$query="UPDATE `tbl_sub_activity_details` SET `sub_activity_percent`= '$data' WHERE `sub_activity_id` = '$id' ";

if ($conn->query($query) === TRUE) {
    return true;
}else{
  return false;
}

$conn->close();

}



function UpdateActivityStartDate($id, $data){
$conn = new mysqli(HOST, USER, PASSWORD, DATABASE);

$query="UPDATE `tbl_sub_activity_details` SET `sub_activity_start_date`= '$data' WHERE `sub_activity_id` = '$id' ";

if ($conn->query($query) === TRUE) {
    return true;
}else{
  return false;
}

$conn->close();

}





function UpdateActivityEndDate($id, $data){
$conn = new mysqli(HOST, USER, PASSWORD, DATABASE);

$query="UPDATE `tbl_sub_activity_details` SET `sub_activity_end_date`= '$data' WHERE `sub_activity_id` = '$id' ";

if ($conn->query($query) === TRUE) {
    return true;
}else{
  return false;
}

$conn->close();

}


/////////////////////////////////////////////////////////////////

function updateAchieve($id, $data){
$conn = new mysqli(HOST, USER, PASSWORD, DATABASE);

$query="UPDATE `tbl_activity_itt` SET `itt_ach`= '$data' WHERE `itt_id` = '$id' ";

if ($conn->query($query) === TRUE) {
    return true;
}else{
  return false;
}

$conn->close();

}

///////////////////////////////////////////////////////////////////

function updateTarget($id, $data){
$conn = new mysqli(HOST, USER, PASSWORD, DATABASE);

$query="UPDATE `tbl_activity_itt` SET `itt_target`= '$data' WHERE `itt_id` = '$id' ";

if ($conn->query($query) === TRUE) {
    return true;
}else{
  return false;
}

$conn->close();

}

///////////////////////////////////////////////////////////////////

function delete_itt($id){
$conn = new mysqli(HOST, USER, PASSWORD, DATABASE);

$query="DELETE FROM `tbl_activity_itt` WHERE `itt_id` = '$id'";

if ($conn->query($query) === TRUE) {
    return true;
}else{
  return false;
}

$conn->close();

}

///////////////////////////////////////////////////////////////////


///////////// Add sub activity here /////////////





function add_new_sub_activity($sub_activity_id, $sub_activity_name, $sub_activity_start, $sub_activity_end, $sub_activity_budget, $sub_activity_desc){
$conn = new mysqli(HOST, USER, PASSWORD, DATABASE);


  $sql = "INSERT INTO `tbl_sub_activity_details`(`sub_activity_id`, `sub_activity_name`, `sub_activity_main_id`, `sub_activity_start_date`, `sub_activity_end_date`, `sub_activity_cost`, `sub_activity_desc`) VALUES (null,'$sub_activity_name','$sub_activity_id', '$sub_activity_start', '$sub_activity_end', '$sub_activity_budget','$sub_activity_desc')";


if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

}




function add_new_activity($sub_activity_id, $act_show_after, $sub_activity_name, $sub_activity_start, $sub_activity_end, $sub_activity_budget){
$conn = new mysqli(HOST, USER, PASSWORD, DATABASE);


  $sql = "INSERT INTO `tbl_activity`(`activity_table_id`, `activity_id`, `activity_show_after`,`activity_name`, `activity_base_date`, `activity_start_date`, `activity_end_date`,`activity_percent`) VALUES (null,'$sub_activity_id', '$act_show_after', '$sub_activity_name','','$sub_activity_start','$sub_activity_end','$sub_activity_budget')";


if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

}


/////////////////// Display select options for activity orders ///////////////

function get_activity_show_after(){
$conn = new mysqli(HOST, USER, PASSWORD, DATABASE);

$sql = "SELECT `activity_id`, `activity_show_after` FROM `tbl_activity` WHERE 1 order by `activity_show_after` ";

$result = $conn->query($sql);
$array = array();
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $array[] = $row;
    }
  }
  $conn->close();

  return $array;
}









function activity_id_remove($activity_id){
$conn = new mysqli(HOST, USER, PASSWORD, DATABASE);


  $sql = "DELETE FROM `tbl_activity` WHERE `activity_table_id` = '$activity_id'";


if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

}

//////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////
///////////////////// TEST TEST TEST /////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////


function test_select(){
$conn = new mysqli(HOST, USER, PASSWORD, DATABASE);

$sql = "SELECT `id`, `output_id`, `title`, `description`, `target`, `achievement`, `variance`, `start_date`, `end_date`, `color`, `oct`, `nov`, `decm`, `jan`, `feb`, `mar`, `apr`, `may`, `jun`, `jul`, `aug`, `sep`, `oct_2`, `nov_2`, `dec_2`, `jan_2`, `feb_2`, `mar_2`, `apr_2`, `may_2`, `jun_2`, `jul_2`, `aug_2`, `sep_2` FROM `tbl_activity_test` WHERE 1";

$result = $conn->query($sql);
$array = array();
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $array[] = $row;
    }
  }
  $conn->close();

  return $array;
}


///////////////////////////////////////////////////////////////////////////////////

function select_all_outputs(){
$conn = new mysqli(HOST, USER, PASSWORD, DATABASE);

$sql = "SELECT `output_id`, `output_desc` FROM `tbl_output` WHERE 1";

$result = $conn->query($sql);
$array = array();
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $array[] = $row;
    }
  }
  $conn->close();

  return $array;
}




///////////////////////////////////////////////////////////////////////////////////

function test_select_to_json(){
    $conn = new mysqli(HOST, USER, PASSWORD, DATABASE);
    $sql = "SELECT tbl_activity_test.`id`, tbl_activity_test.`output_id`, tbl_activity_test.`title`, tbl_activity_test.`description`, tbl_activity_test.`target`, tbl_activity_test.`achievement`, tbl_activity_test.`variance`, tbl_activity_test.`start_date`,tbl_activity_test.`end_date`,tbl_activity_test.`color`, tbl_activity_test.`oct`, tbl_activity_test.`nov`, tbl_activity_test.`decm`, tbl_activity_test.`jan`, tbl_activity_test.`feb`, tbl_activity_test.`mar`, tbl_activity_test.`apr`, tbl_activity_test.`may`, tbl_activity_test.`jun`, tbl_activity_test.`jul`, tbl_activity_test.`aug`, tbl_activity_test.`sep`, tbl_activity_test.`oct_2`, tbl_activity_test.`nov_2`, tbl_activity_test.`dec_2`, tbl_activity_test.`jan_2`, tbl_activity_test.`feb_2`, tbl_activity_test.`mar_2`, tbl_activity_test.`apr_2`, tbl_activity_test.`may_2`, tbl_activity_test.`jun_2`, tbl_activity_test.`jul_2`, tbl_activity_test.`aug_2`, tbl_activity_test.`sep_2`, tbl_output.`output_desc`, tbl_outcome.`outcome_desc` FROM `tbl_activity_test`
      LEFT JOIN tbl_output
      ON tbl_activity_test.output_id = tbl_output.output_id
      LEFT JOIN tbl_outcome
      ON tbl_output.output_outcome_id = tbl_outcome.outcome_id";

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {

            $rows = array();
            while($r = mysqli_fetch_assoc($result)) {
                $rows[] = $r;
            }

            $fp = fopen('json/sub_activities.json', 'w');
            fwrite($fp, json_encode($rows, JSON_UNESCAPED_UNICODE ));
            fclose($fp);

            $conn->close();
          }
}

///////////////////////////////////////////////////////////////////////////////////

function test_select_activity(){
    $conn = new mysqli(HOST, USER, PASSWORD, DATABASE);
    $sql = "SELECT `test_id`, `test_id_num`, `test_title`, `test_desc`, `test_start_date`, `act_due_date`, `act_budget`, `act_spend`, `test_color` FROM `tbl_activity_test_details` WHERE 1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {

            $rows = array();
            while($r = mysqli_fetch_assoc($result)) {
                $rows[] = $r;
            }

            $fp = fopen('json/activity_details.json', 'w');
            fwrite($fp, json_encode($rows, JSON_UNESCAPED_UNICODE ));
            fclose($fp);

            $conn->close();
          }
}

///////////////////////////////////////////////////////////////////////////////////

function get_activity_color($id){
$conn = new mysqli(HOST, USER, PASSWORD, DATABASE);

$sql = "SELECT `test_color` FROM `tbl_activity_test_details` WHERE `test_id_num` = $id";

$result = $conn->query($sql);
$count = 0;

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {

    $count = $row['test_color'];

    }
  }else{
    return 'white';
  }
  $conn->close();

  return $count;

}


///////////////////////////////////////////////////////////////////////////////////
/////////////////////SPEED UP TEST FUNCTION IS HERE////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////

function get_activity_color_bdg_exp($id){
$conn = new mysqli(HOST, USER, PASSWORD, DATABASE);

$sql = "SELECT `act_budget`, `act_spend`, `test_color` FROM `tbl_activity_test_details` WHERE `test_id_num` = $id limit 1";

$result = $conn->query($sql);
$count = array();

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {

    $row['act_budget_percent'] = (($row['act_spend']*100)/$row['act_budget'])." %";
    $row['act_budget_percent'] = number_format((float)$row['act_budget_percent'], 0, '.', '');


    $spend = $row['act_spend'];
    $row['act_spend_edited'] = number_format((float)$spend, 0, '.', ''); 
 

    $count[] = $row;

    }
  }else{
    return 'white';
  }
  $conn->close();

  return $count;

}



///////////////////////////////////////////////////////////////////////////////////

function get_activity_percent($id){
$conn = new mysqli(HOST, USER, PASSWORD, DATABASE);

$sql = "SELECT `act_budget`, `act_spend` FROM `tbl_activity_test_details` WHERE `test_id_num` = '$id'";

$result = $conn->query($sql);
$count = 0;

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {

    $count = (($row['act_spend']*100)/$row['act_budget']);
    $count = number_format((float)$count, 0, '.', ''); 

    }

  }else{
    return '$';
  }
  $conn->close();

  return $count;

}
///////////////////////////////////////////////////////////////////////////////////



function get_activity_budget($id){
$conn = new mysqli(HOST, USER, PASSWORD, DATABASE);

$sql = "SELECT `act_budget`, `act_spend` FROM `tbl_activity_test_details` WHERE `test_id_num` = $id";

$result = $conn->query($sql);
$count = 0;

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {

    $count = $row['act_budget'];
    $count = number_format((float)$count, 0, '.', ''); 

    }
  }

  $conn->close();

  return $count;

}

///////////////////////////////////////////////////////////////////////////////////

function get_activity_expense($id){
$conn = new mysqli(HOST, USER, PASSWORD, DATABASE);

$sql = "SELECT `act_spend` FROM `tbl_activity_test_details` WHERE `test_id_num` = $id";

$result = $conn->query($sql);
$count = 0;

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {

    $count = $row['act_spend'];
    $count = number_format((float)$count, 0, '.', ''); 

    }
  }

  $conn->close();

  return $count;

}

/////////////////

function get_activity_clean_up(){

  $oct_budget = 0;
  $nov_budget = 0;
  $decm_budget = 0;
  $jan_budget = 0;
  $feb_budget = 0;
  $mar_budget = 0;
  $apr_budget = 0;
  $may_budget = 0;
  $jun_budget = 0;
  $jul_budget = 0;
  $aug_budget = 0;
  $sep_budget = 0;
  $oct_2_budget = 0;
  $nov_2_budget = 0;
  $dec_2_budget = 0;
  $jan_2_budget = 0;
  $feb_2_budget = 0;
  $mar_2_budget = 0;
  $apr_2_budget = 0;
  $may_2_budget = 0;
  $jun_2_budget = 0;
  $jan_2_budget = 0;
  $aug_2_budget = 0;
  $sep_2_budget = 0;

}




 
///////////////////////////////////////////////////////////////////////////////////

function update_activity_details($act_id, $act_id_num, $act_name, $act_desc, $act_start_date, $act_due_date, $act_budget, $act_percent, $act_color){
$conn = new mysqli(HOST, USER, PASSWORD, DATABASE);

$sql = "UPDATE `tbl_activity_test_details` SET `test_title`='$act_name',`test_desc`='$act_desc',`test_start_date`='$act_start_date',`act_due_date`='$act_due_date',`act_budget`='$act_budget',`act_spend`='$act_percent',`test_color`='$act_color' WHERE `test_id` = '$act_id' ";

if ($conn->query($sql) === TRUE) {
    return true;
}else{
  return false;
}
$conn->close();

}

///////////////////////////////////////////////////////////////////////////////////

function add_activity_details($act_id, $act_id_num, $act_name, $act_desc, $act_start_date, $act_due_date, $act_budget, $act_percent, $act_color){
$conn = new mysqli(HOST, USER, PASSWORD, DATABASE);

$sql = "INSERT INTO `tbl_activity_test_details`(`test_id`, `test_id_num`, `test_title`, `test_desc`, `test_start_date`, `act_due_date`, `act_budget`, `act_spend`, `test_color`) VALUES (null,'$act_id_num','$act_name','$act_desc','$act_start_date','$act_due_date','$act_budget','$act_percent','$act_color')";

if ($conn->query($sql) === TRUE) {
    return true;
}else{
  return false;
}
$conn->close();

}

///////////////////////////////////////////////////////////////////////////////////

function update_activity($act_id, $act_title, $act_start_date, $act_due_date, $act_target, $act_achievement, $act_varience, $act_desc){
$conn = new mysqli(HOST, USER, PASSWORD, DATABASE);

$sql = "UPDATE `tbl_activity_test` SET `title`='$act_title', `description`='$act_desc', `target`='$act_target', `achievement`='$act_achievement', `variance`='$act_varience', `start_date`='$act_start_date', `end_date`='$act_due_date' WHERE `id` = '$act_id'";

if ($conn->query($sql) === TRUE) {
    return true;
}else{
  return false;
}
$conn->close();

}

///////////////////////////////////////////////////////////////////////////////////

function select_all_output(){
$conn = new mysqli(HOST, USER, PASSWORD, DATABASE);

$sql = "SELECT `output_id`, `output_desc` FROM `tbl_output` WHERE 1";

$result = $conn->query($sql);
$array = array();
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $array[] = $row;
    }
  }
  $conn->close();

  return $array;
}

///////////////////////////////////////////////////////////////////////////////////


///////////////////////////////////////////////////////////////////////////////////

function select_all_outcome(){
$conn = new mysqli(HOST, USER, PASSWORD, DATABASE);

$sql = "SELECT `outcome_id`, `outcome_desc` FROM `tbl_outcome` WHERE 1";

$result = $conn->query($sql);
$array = array();
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $array[] = $row;
    }
  }
  $conn->close();

  return $array;
}


///////////////////////////////////////////////////////////////////////////////////

function select_all_itt(){
    $conn = new mysqli(HOST, USER, PASSWORD, DATABASE);
    $sql = "SELECT `itt_id`, `itt_act_id`, `itt_target`, `itt_ach`, `itt_var` FROM `tbl_activity_itt` WHERE 1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {

            $rows = array();
            while($r = mysqli_fetch_assoc($result)) {
                $rows[] = $r;
            }

            $fp = fopen('json/select_all_itt.json', 'w');
            fwrite($fp, json_encode($rows, JSON_UNESCAPED_UNICODE ));
            fclose($fp);

            $conn->close();
          }
}

///////////////////////////////////////////////////////////////////////////////////

function insert_new_itt($target, $achievement, $act_id){
$conn = new mysqli(HOST, USER, PASSWORD, DATABASE);

$sql = "INSERT INTO `tbl_activity_itt`(`itt_id`, `itt_act_id`, `itt_target`, `itt_ach`, `itt_var`) VALUES (null,'$act_id','$target','$achievement','0')";

if ($conn->query($sql) === TRUE) {
    return true;
}else{
  return false;
}
$conn->close();

}

///////////////////////////////////////////////////////////////////////////////////////
////////////////////////////// ADD, DELETE Activity, Output, Outcome //////////////////

function add_fresh_activity($act_new_name, $act_output_id){
$conn = new mysqli(HOST, USER, PASSWORD, DATABASE);

$sql = "INSERT INTO `tbl_activity_test`(`id`, `output_id`, `title`) VALUES (null,'$act_output_id','$act_new_name')";

if ($conn->query($sql) === TRUE) {
    return true;
}else{
  return false;
}
$conn->close();

}

///////////////////////////////////////////////////////////////////////////////////////

function delete_fresh_activity($id){
$conn = new mysqli(HOST, USER, PASSWORD, DATABASE);

$sql = "DELETE FROM `tbl_activity_test` WHERE `id` = '$id'";

if ($conn->query($sql) === TRUE) {
    return true;
}else{
  return false;
}
$conn->close();

}

//////////////////////////////////////////////////////////////////////////////////////

function insert_new_output($outcome_id, $desc){
$conn = new mysqli(HOST, USER, PASSWORD, DATABASE);

$sql = "INSERT INTO `tbl_output`(`output_id`, `output_outcome_id`, `output_desc`) VALUES (null, '$outcome_id', '$desc')";

if ($conn->query($sql) === TRUE) {
    return true;
}else{
  return false;
}
$conn->close();

}

//////////////////////////////////////////////////////////////////////////////////////

function insert_new_outcome($desc){
$conn = new mysqli(HOST, USER, PASSWORD, DATABASE);

$sql = "INSERT INTO `tbl_outcome`(`outcome_id`, `outcome_desc`) VALUES (null, '$desc')";

if ($conn->query($sql) === TRUE) {
    return true;
}else{
  return false;
}
$conn->close();

}

/////////////////////////////////////////////////////////////////////////////////////

function calculate_percentage_tracker($budget, $expense){



$percentage = (($expense * 100)/$budget);
$percentage = number_format($percentage, 1);



  return $percentage. "%";
}


/////////////////////////////////////////////////////////////////////////////////////

function delete_output($id){
$conn = new mysqli(HOST, USER, PASSWORD, DATABASE);

$sql = "DELETE FROM `tbl_output` WHERE `output_id` = '$id'";

if ($conn->query($sql) === TRUE) {
    return true;
}else{
  return false;
}
$conn->close();

}

/////////////////////////////////////////////////////////////////////////////////////

function delete_outcome($id){
$conn = new mysqli(HOST, USER, PASSWORD, DATABASE);

$sql = "DELETE FROM `tbl_outcome` WHERE `outcome_id` = '$id'";

if ($conn->query($sql) === TRUE) {
    return true;
}else{
  return false;
}
$conn->close();

}

//////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////Tracker Test Functions///////////////////////////////////


//////////////////////////////////////////////////////////////////////////////////////////

function if_question_is_16($id){
$conn = new mysqli(HOST, USER, PASSWORD, DATABASE);

$sql = "SELECT COUNT(`answer_question_code`) as TotalOption FROM `tbl_answer` WHERE `answer_question_code` = '$id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {

    if($row['TotalOption'] > 0){
      $TotalOption = 1;
    }else{
      $TotalOption = 0;
    }
  }
}else{
  echo "Nothing to show";
}
return $TotalOption;
}





///////////////////////////////// NEW ACTIVITY_NEW.PHP IS HERE ///////////////////////


/////////////////////////////////////////////////////////////////////////////////////

} // end of the function is here


$query_functions = new query_functions;


?>
