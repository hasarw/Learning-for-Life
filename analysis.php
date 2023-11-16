<?php

require_once "/includes/function.php";
require_once "header.php";
require_once "query_functions.php";

$functions = new query_functions();
?>

<div class="container" ng-app="myModule">
<div class="row" ng-controller="ctrlRead">

<form class="form-inline hidden-print" method="post" action="analysis.php">
<label>Search for Question Number:</label>

<select name="question_code" ng-model="filterDistrict" ng-options="items.question_code as items.question_code group by item.question_code for items in items" class="form-control" style="height: 40px">
</select>

<button class="btn btn-info" name="submit">Go</button>
<br/><br/>
</form>

<?php

if(isset($_POST['submit'])){

$question_code = $_POST['question_code'];

$conn = new mysqli(HOST, USER, PASSWORD, DATABASE);
$myArray = explode(':', $question_code);
$question_code = $myArray[1];

$sql = "SELECT tbl_question.`question_desc`, tbl_answer.`answer_code` FROM `tbl_question`,`tbl_answer` WHERE `question_code` = '$question_code'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $question_desc = $row['question_desc'];
  }
}


//This section is for showing the question and all corsponding options!

echo "<div class='jumbotron'><p>".$question_desc."</p>";

?>



<?php
////////////////////////////  Fuck UPUPUPUP  \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\


$sql = "SELECT COUNT(`answer_question_code`) as TotalOption FROM `tbl_answer` WHERE `answer_question_code` = '$question_code'";
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


//IF TOTAL OPTION WAS ZERO /////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////

if($TotalOption == 0){

    echo "<div class='col-md-12'>
    <div class='jumbotron' style='background-color: #99ccff'>
    <div class=''>
        <table class='table table-bordered'>
        <tr class='text-white-shadow tr-highlight' style='background-color='#0066ff''>
        <th class='tr-center-color tr-highlight'>Answers</th>
        <th class='tr-center-color tr-highlight'>Participants</th>
        <th class='tr-center-color tr-highlight'>Percentages</th>
        </tr>";

$sql = "SELECT tbl_benf_answers.`$question_code`, tbl_benf.benf_name from tbl_benf_answers, tbl_benf where tbl_benf_answers.survey_code = tbl_benf.benf_survey_code";
$result = $conn->query($sql);
  

  $total = 0;
  
  foreach (($functions -> get_percentage($question_code)) as $key) {

    $total_percentage = ((int)$key['theCount'] / 655) * 100;
    echo "<tr><td>".$key['theAns']."</td><td>".$key['theCount']."</td><td>".number_format($total_percentage,2)."</td></tr>";
    
    $float += (float)$total_percentage;
  }

  echo "</table></div>";

// Here is the place for Pie Chart or something else

echo "</div></div>";

  ?>

<table class="table table-bordered">
<tr>
  <th>Beneficiary</th>
  <th>Answer</th>
</tr>

<?php


if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {

    $var1 = $row[$question_code];

      echo "<tr><td>".$row['benf_name']."</td><td>".$row[$question_code]."</td></tr>";
  }
}

$conn->close();



// echo "<canvas id='bar' class='chart chart-bar' chart-data='data' chart-labels='labels' click='onClick' series='series'> chart-series='series' </canvas>";

}
echo "</table>";




//////////////// END OF TOTAL OPTION EQUALS TO ZERO SECTION ////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////





// IF TOTAL OPTIONS ARE EQUALS TO ONE //////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////

if($TotalOption == 1){


// THE FIRST COLUMN ////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////

  echo "<div class='col-md-6 column-color'>";

$optionCounter = 1;
foreach (($functions -> listOptions($question_code)) as $key) {

  echo "<p class='text-class'>Option ".$optionCounter." - <span class='answer_class' id='a-".$optionCounter."'>".$key['answer_desc']."".$x."</p>";

  $optionsDesc .= "'".$key['answer_desc']."',";
  $optionCounter++;

}
$ops = rtrim($optionsDesc, ",");

echo "</div>";
// THE END OF FIRST COLUMN /////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////

// THE SECOND COLUMN ///////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////

echo "<div class='col-md-6 column-color'>";

//Code for Optional questions
$sql = "SELECT `answer_code` FROM `tbl_answer` WHERE `answer_question_code` = '$question_code'";
$result = $conn->query($sql);
$answers = array();

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    //save it all to an array and then use it for another loop
       $answerss[] = $row;
  }
}

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


  $keys = 1;
  foreach ($ssss as $key => $value) {
  foreach ($value as $key => $x) {
      $total_percentage = ((int)$x / 655) * 100;    
      echo "<p class=''><span class=''>".number_format($total_percentage,2)." %</span></p>";
      $float += (float)$total_percentage;

      } 
    }

echo "</div>";

// THE END OF SECOND COLUMN ////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////


////////////////// KEEP CALM AND CODE IN PURE PHP //////////////////////////////////////////

////////////////// HEKMAT SARWARZADAH //////////////////////////////////////////////////////

////////////////// FUCK DANIEL EDWARD //////////////////////////////////////////////////////


//Code for Optional questions
$sql = "SELECT `answer_code` FROM `tbl_answer` WHERE `answer_question_code` = '$question_code'";
$result = $conn->query($sql);
$answers = array();

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    //save it all to an array and then use it for another loop
       $answers[] = $row;
  }
}

$query = ($functions -> createChart($answers));

$sss = ($functions -> chartData($query));


//get the lenght of array
$count = 0;
foreach ($sss as $type) {
    $count+= count($type);
}


for ($i=1; $i < $count; $i++) {
  $columns = "col_".$i;
  foreach ($sss as $key) {
    $data .= $key[$columns].",";
  }
}


$data = rtrim($data, ",");


?>

<canvas id="bar" class="chart chart-bar" chart-data="data" chart-labels="labels" click="onClick" series="series"> chart-series="series"
</canvas>

<hr>


<?php

$cols = ($functions -> getResult($answers));

$arraye = array();
$sql = "SELECT $cols tbl_benf.benf_name FROM `tbl_benf`,`tbl_benf_answers` WHERE tbl_benf.benf_survey_code = tbl_benf_answers.survey_code";
$result = $conn->query($sql);

?>
<div class="table-responsive">
<table class="table table-bordered">
<tr>
  <th>Beneficiary Name</th>
  <?php
  $count = 1;
  foreach ($answers as $key) {
    echo "<th>Option ".$count."</th>";
    $count++;
  }
  ?>
</tr>

<?php

// when the canves needed

if ($result->num_rows > 0) {

  while($row = $result->fetch_assoc()) {
        $arraye[] = $row;
        echo "<tr><td>".$row['benf_name']."</td>";

        foreach ($answers as $key) {
          echo "<td>".$row[$key['answer_code']]."</td>";
        }

        echo "</tr>";
  }
  echo "</table></div>";
}
$conn->close();

} // for current if statement


} // for submit


?>


</div>
</div>

<?php require_once "footer.php"; ?>

<script type="text/javascript" src="assets/js/ui-bootstrap-tpls-2.3.1.min.js"></script>
<script type="text/javascript" src="assets/js/dirPagination.js"></script>
<script type="text/javascript" src="assets/js/angular-filter.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
<script src="assets/js/angular-chart.min.js"></script>

<?php $d = $data; ?>
<?php $s = $ops; ?>

<script type="text/javascript">

var app = angular.module('myModule', ['chart.js','angularUtils.directives.dirPagination','angular.filter'])
app.controller('ctrlRead', ['$scope','$filter' ,'$http', function ($scope, $filter, $http) {

  $scope.onClick = function (points, evt) {
      console.log(points[0].value); // 0 -> Series A, 1 -> Series B
      alert('asdasdas');
    };

    $scope.labels = [ <?php echo "".$s; ?> ];
    $scope.series = ['Series A'];
    $scope.data = [
      [ <?php echo "".$d; ?> ]
    ];
    $scope.color = ['#005ce6'];


    $scope.options = {legend: {display: true, position: 'bottom'}};

    angular.element(document).ready(function(){

        var request2 = $http({
            method: "get",
            url : "questions.json"
        });

        request2.then(function(response){
            $scope.items = response.data;
        });
});
}]);
</script>

<script type="text/javascript">
// $( document ).ready(function() {


// $(".answer_class").click(function(){
//   var idOrgin = ($(this).attr('id'));
   
//    var desc = $('#'+idOrgin).text();

//    $('#text-1').val(desc);
//    $('#text-1').text(desc);

// });
// });




</script>
