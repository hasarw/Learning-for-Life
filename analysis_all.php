<?php

require_once "/includes/function.php";
require_once "header.php";
require_once "query_functions.php";

$functions = new query_functions();
?>

<div class="container">
<div class="row">


<div class="col-md-12">
  <div class="table-responsive">
    
  <table class="table table-bordered">
    
  <tr class="tr-center-color">
    <th class="text-center">#</th>
    <th class="text-center">Question Description</th>
    <th class="text-center" style="width: 15%">Answer</th>
    <th class="text-center">Percentage</th>
  </tr>

<?php

$conn = new mysqli(HOST, USER, PASSWORD, DATABASE);


foreach (($functions -> getAllQuestion()) as $key) {

  $sql = "SELECT tbl_question.`question_desc`, tbl_question.`question_answer`, tbl_answer.`answer_code` FROM `tbl_question`,`tbl_answer` WHERE `question_code` = '$key[question_code]' order by tbl_question.`question_answer` limit 1";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {

    $question_desc = $row['question_desc'];
    $theQuestionNum = $key['question_code'];

    //Printing Questions Code && Question Description

    echo "<tr><td><p>".$key['question_code']."</p></td>";



    echo "<td><p>".$row['question_desc']."<br><br/>".$row['question_answer']."</p></td>";




if($functions->if_question_is_16($key['question_code']) != 1){

    //Printing Question Answers and Question Percentages 
    echo "<td><p>";
    foreach (($functions -> get_percentage($key['question_code'])) as $key){

      if($key['theAns'] == ""){
        $answer = "N/A";
      }else{
        $answer = $key['theAns'];
      }


      echo $answer."<br/>";

    }

    echo "</p></td>";

    echo "<td><p>";

      foreach (($functions -> get_percentage($theQuestionNum)) as $key){
      $total_percentage = ((int)$key['theCount'] / 655) * 100;

      $float += (float)$total_percentage;
      $float = number_format($total_percentage,2);

      echo $float." %<br/>";

      }

    echo "</p></td>";

//////////////////////////// DANGER ZONE ///////////////////////////////////////////////////

/////////////////////////////////// REDUCE YOUR SPEED //////////////////////////////////////
//UP//UP//UP//UP//UP//UP// THE RECENT LOOP WHICH I ADDED //DOWN FREE//UP//UP//UP//UP////////
    
} // end of the IF statement

////////////////////////////////////// New Function Required Here //////////////////////////

    if($functions->if_question_is_16($key['question_code']) == 1){

    $val = $key['question_code'];

    $optionCounter = 1;
    echo "<td>";

    foreach (($functions -> listOptions($key['question_code'])) as $key) {

      echo "<p>".$optionCounter." - ".$key['answer_desc']."</p>";

      $optionsDesc .= "'".$key['answer_desc']."',";
      $optionCounter++;

    }

    echo "</td>";
    $ops = rtrim($optionsDesc, ",");

////////////////// NEXT STEP - PERCENTAGE ///////////////////////////////////////////

//Code for Optional questions
$sql = "SELECT `answer_code` FROM `tbl_answer` WHERE `answer_question_code` = '$val'";
$result = $conn->query($sql);
$answerss = array();


if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    //save it all to an array and then use it for another loop
       $answerss[] = $row;
  }
}
//////////////////////////////////////////////////////////////////////////////////////


$queryies = ($functions -> createChart($answerss));
$ssss = ($functions -> chartData($queryies));

//get the lenght of array

$count = 0;
foreach ($ssss as $type) {
    $count+= count($type);
}


for ($i=1; $i < $count; $i++) {
  $columns = "col_".$i;
  foreach ($ssss as $key) {
    $datas .= $key[$columns].",";
  }
}

$datas = rtrim($datas, ",");

  echo "<td>";

  $keys = 1;
  foreach ($ssss as $key => $value) {

  foreach ($value as $key => $x) {
      $total_percentage = ((int)$x / 655) * 100;    
      echo "<p>".number_format($total_percentage,2)." %</p>";
      }
    }

echo "</td>";

}




    
  } // While loop end
  } //End of IF
  echo "</tr>";
} // end of foreach

?>

  </table>

  </div>
</div>

</div>
</div>

<?php require_once 'footer.php'; ?>