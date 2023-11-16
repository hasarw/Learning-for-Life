<?php

require_once "header.php";
require_once "query_functions.php";
$functions = new query_functions();

if($_SESSION['member_type'] != 1){

  echo "<script>alert('You should login as an Administrator to access this page.');

  window.location = 'Home.php';</script>";

  die();


}

?>

<div class="container" style="margin-top: 150px">
<div class="row" ng-app="myapp" ng-controller="empcontroller">

<div class="col-md-6">

          <form class="form-horizontal" style="padding-top: 40px;">

            <div class="form-group">
            <div class="col-md-3">
              <label class="control-label col-sm-2" for="title" style="text-align:left !important">Title</label>
              </div>
              <div class="col-md-9">
              <input type="text" id="title" class="form-control" placeholder="Title" ng-model="update_title" />
            </div>
            </div>

            <div class="form-group">
            <div class="col-md-3">
              <label class="control-label col-sm-2">Description</label></div>
              <div class="col-md-9">
              <textarea class="form-control" rows="5" id="comment1"
              placeholder="Description" ng-model="update_desc"></textarea>
            </div>
          </div>

          <div class="" style="text-align=right; float:right">
               <button class="btn btn-info" ng-click="postData()">Submit</button>
          </div>

          <p id="message"></p>
          </form>

</div>


<div class="col-md-6">

          <div class="form-horizontal" style="padding-top: 40px">

            <table class="table tableScrollUpdate">
              <?php
              $id = 0;
              foreach ($functions -> getUpdates() as $x) {
                echo "<tr><td class='td-class' id='td-$id'><p><span class='glyphicon glyphicon-paperclip'></span> ".$x['update_title']."  <br/><span class='small-font'>".$x['update_date']." by: ".$x['member_name']."</span><a href='#' class='btn btn-sm' data-toggle='modal' data-target='#show_data'>Edit</a></p></td>";
                echo "<p class='hidden p-class' id='ttd-$id'>".$x['update_title']."</p>";
                echo "<p class='hidden p-class' id='ptd-$id'>".$x['update_desc']."</p>";
                echo "<p class='hidden p-class' id='itd-$id'>".$x['update_id']."</p>";
                echo "<td><a href='project_update.php?update_id=".$x['update_id']."' type='button' onclick='return checkDelete()' class='btn btn-sm'>Remove</a></td></tr>";
                $id++;
              }
              ?>
            </table>

          </div>

</div>


<!-- Modal - Update User details -->
<div class="modal fade" id="show_data" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title modal-title-title"></h4>
            </div>
            <div class="modal-body">
                <form class="form" method="post" action="project_update.php" >
                <input type="number" class="form-control id_data hidden" name="id_text">

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


</div>
</div>

<?php require_once "footer.php"; ?>

<?php

if(isset($_POST['submit'])){

  $id = $_POST['id_text'];
  $title = $_POST['title_text'];
  $desc = $_POST['desc_text'];

  if($functions -> SetUpdate($id,$title,$desc)){
  echo "<script>window.location = 'home.php';</script>";
  };

}

if(isset($_GET['update_id'])){
  $id = $_GET['update_id'];
  if($functions -> deleteUpdate($id)){
  echo "<script>window.location = 'project_update.php';</script>";
  };

}


?>



<script type="text/javascript">

var app = angular.module('myapp', []);

app.controller('empcontroller', function ($scope, $http) {



$scope.postData = function () {

    var request = $http({
        method: "post",
        url: "insert_update.php",
        data: {
            update_title: $scope.update_title,
            update_desc: $scope.update_desc,
        },
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
    });

 request.then(function (data) {
   $scope.update_title = "";
   $scope.update_desc = "";
    document.getElementById("message").textContent = "Your Update Saved!";
    window.location = 'project_update.php';
});
}

});

</script>


<script>
$(".td-class").click(function(){

   var idOrgin = ($(this).attr('id'));

   var id = '#p'+idOrgin;
   var str = $(id).text();

   var title = '#t'+idOrgin;
   var titleText = $(title).text();

   var id_num = '#i'+idOrgin;
   var update_id = $(id_num).text();


  //  $('.desc_data').html(str);
   $('.desc_data').val(str);

   $('.modal-title-title').html(titleText);
   $('.title_data').val(titleText);

  // The update id set to form
   $('.id_data').val(update_id);

});
</script>


<script language="JavaScript" type="text/javascript">
function checkDelete(){
    return confirm('Are you sure?');
}
</script>
