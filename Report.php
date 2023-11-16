<?php

require_once "/includes/function.php";
require_once "/includes/config.php";
require_once "header.php";

require_once "query_functions.php";

$functions = new query_functions();

session_start();

?>

<div ng-app="myApp">
<div ng-controller="myCtrl">
<div class="container">

<div class="row">



<?php

if ($_SESSION['member_type'] == 1){
  echo "<div class='row' id='form-platte'>
  <button class='btn btn-sm btn-info' data-toggle='collapse' id='menu-toggle-1' data-target='#newReport'>Submit a New Report <i class='glyphicon glyphicon glyphicon-menu-down'></i></button>
  </div>";
}

?>

<div class="media-form collapse" id="newReport">
<!-- <div class="file-upload collapse" id="newReport"> -->

<div class="row" >
<div class="col-md-4">
<form name="myForm" id="form-platte" style="padding-right: 15px; padding-left: 15px;">

<br>
  <div class="form-group">
    <label for="title">Report Title:</label>
    <input type="text" class="form-control" id="title" ng-model="upload_title" required />
  </div>

  <div class="form-group">
    <label for="title">Report Description:</label>
    <input type="text" class="form-control" id="desc" ng-model="upload_desc" required />
  </div>

  <div class="form-group">
    <label>Only excel and PDF are supported.</label>
      <input type="file"  file-model="myFile" class="btn" accept="application/pdf,application/vnd.ms-excel" required />
  </div>

  <div class="form-group">
    <button class="btn btn-info" ng-click="uploadFile()">Submit</button>
  </div>
</form>
</div>

</div>

</div>
</div>

<hr>

<button data-toggle="collapse" id="menu-toggle-2" data-target="#showReport_div" class="btn btn-sm btn-info">Show Submitted Reports <i class="glyphicon glyphicon glyphicon-menu-down"></i></button>
<br/>
<br/>



  <div class="collapse" id="showReport_div">
    <div class="row">

      <?php
      $conn = new mysqli(HOST, USER, PASSWORD, DATABASE);
      $sql = "SELECT tbl_report.report_id, tbl_members.member_name, tbl_report.report_user_id, tbl_report.report_date, tbl_report.report_title, tbl_report.report_desc, tbl_report.report_upload_file FROM tbl_report, tbl_members where tbl_members.member_id = tbl_report.report_user_id ORDER BY tbl_report.report_date DESC";
      $result = $conn->query($sql);
      $table = array();
      $count = 0;
      $number = 1;
      if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {

          if($count == 4){
            echo "<div class = 'row'>";
            $count = 0;
          }
          echo "
          <div class='col-lg-3 col-md-4 col-xs-6 thumb'>

              <a class='thumbnail' id='fid-$row[report_id]' href='upload/$row[report_upload_file]'>
                  <img class='img-responsive' src='assets/img/report.png' alt='' style='width: 200px'>
              </a>

                  <b>Title: </b><span id='tid-$row[report_id]'>$row[report_title]</span><br>
                  <b>Submitted date: </b><span id = 'didate-$row[report_id]'>$row[report_date]</span><br/>
                  <b>By: </b><span id= 'nid=$row[report_id]'>$row[member_name]</span><br/>
                  <b>Description: </b><span id = 'did-$row[report_id]'>$row[report_desc]</span><br>
                  <span><a class='text-primary td-class' href='' id='$row[report_id]' data-toggle='modal' data-target='#show_data'>Edit</a></span> |
                  ";

                  if($_SESSION['member_type'] == 1){
                    echo "<span><a class='text-warning' onclick='return checkDelete()' href='report.php?report_id=$row[report_id]&file=$row[report_upload_file]'>Remove</a></span>";
                  }


          echo "</div>";

          $number++;
          $count++;
          if($count >= 4){
            echo "</div>";

          }
        }
      }
      $conn->close();
      ?>


    </div>

  </div>

</div>
</div>
</div>

<!-- Modal - Update User details -->
<div class="modal fade" id="show_data" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title modal-title-title">Edit Report</h4>
            </div>
            <div class="modal-body">
                <form class="form" method="post" action="report.php" >
                <input type="number" class="form-control id_data hidden" name="id_text">

                <div class="form-group">
                  <label for="desc">Date:</label>
                  <input type="text" class="form-control date_data" name="date_text" disabled />
                </div>

                <div class="form-group">
                  <label for="title">Title:</label>
                  <input type="text" class="form-control title_data" name="title_text">
                </div>

                <div class="form-group">
                  <label for="desc">Description:</label>
                  <textarea class="form-control desc_data" name="desc_text"></textarea>
                </div>


                <button type="submit" class="btn btn-default" name="submit">Save</button>
              </form>
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>
<!-- // Modal -->

<?php require_once "footer.php"; ?>

<script type="text/javascript" src="assets/js/ng-file-upload.min.js"></script>

<script>

var myApp = angular.module('myApp', []);

myApp.directive('fileModel', ['$parse', function ($parse) {
    return {
    restrict: 'A',
    link: function(scope, element, attrs) {
        var model = $parse(attrs.fileModel);
        var modelSetter = model.assign;

        element.bind('change', function(){
            scope.$apply(function(){
                modelSetter(scope, element[0].files[0]);
            });
        });
    }
   };
}]);

// We can write our own fileUpload service to reuse it in the controller
myApp.service('fileUpload', ['$http', function ($http) {
    this.uploadFileToUrl = function(file, uploadUrl, upload_title, upload_desc){
         var fd = new FormData();
         fd.append('file', file);
         fd.append('name', upload_title);
         fd.append('desc', upload_desc)
         $http.post(uploadUrl, fd, {
             transformRequest: angular.identity,
             headers: {'Content-Type': undefined,'Process-Data': false}
         })
         .then(function(){
            console.log("Success");

         })
         .catch(function(){
            console.log("Success 1");
            location.reload('Report.php');
         });
     }
 }]);

 myApp.controller('myCtrl', ['$scope', 'fileUpload', function($scope, fileUpload){

   $scope.uploadFile = function(){
        var file = $scope.myFile;
        console.log('file is ' );
        console.dir(file);

        if($scope.upload_title )

        var uploadUrl = "save_form.php";
        var text = $scope.upload_title;
        var text2 = $scope.upload_desc;
        fileUpload.uploadFileToUrl(file, uploadUrl, text, text2);

        location.reload('report.php');
   };

}]);

$('#menu-toggle-1').click(function(){
    $(this).find('i').toggleClass('glyphicon glyphicon-menu-up').toggleClass('glyphicon glyphicon-menu-down');
});

$('#menu-toggle-2').click(function(){
    $(this).find('i').toggleClass('glyphicon glyphicon-menu-up').toggleClass('glyphicon glyphicon-menu-down');
});


</script>


<script>
$(".td-class").click(function(){
   var idOrgin = ($(this).attr('id'));

   var title_id = '#tid-'+idOrgin;
   var desc_id = '#did-'+idOrgin;
   var file_id = '#fid-'+idOrgin;
   var date_id = '#didate-'+idOrgin;

   var title = $(title_id).text();
   var desc = $(desc_id).text();
   var file = $(file_id).text();
   var date = $(date_id).text();

   $('.id_data').val(idOrgin);
   $('.title_data').val(title);
   $('.desc_data').val(desc);
   $('.file_data').val(file);
   $('.date_data').val(date);

  //  $('.desc_data').html(str);
});
</script>

<script language="JavaScript" type="text/javascript">
function checkDelete(){
    return confirm('Are you sure?');
}
</script>

<?php

if(isset($_POST['submit'])){

  $id_text = $_POST['id_text'];
  $date_text = $_POST['date_text'];
  $title_text = $_POST['title_text'];
  $desc_text = $_POST['desc_text'];


  $conn = new mysqli(HOST, USER, PASSWORD, DATABASE);

  $sql = "UPDATE `tbl_report` SET `report_title` = '$title_text', `report_desc` = '$desc_text' WHERE `report_id` = $id_text";

  if ($conn->query($sql) === TRUE) {
      echo "<script>window.location = 'Report.php';</script>";
  } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
  }

  $conn->close();

}

  if(isset($_GET['report_id'])){

    $id = $_GET['report_id'];
    $file = $_GET['file'];

    if($functions -> deleteReport($id, $file)){
    echo "<script>window.location = 'report.php';</script>";
    };
}



?>
