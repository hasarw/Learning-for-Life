<?php

require_once "/includes/function.php";
require_once "db.php";
require_once "query_functions.php";
require_once "header.php";

$functions = new query_functions();

$functions->getTrackerActivity();

$functions->getTrackerSubActivity();

?>

    <div class="container">
    <div class="row" ng-app="myModule">
    <div id="container" ng-controller="ctrlRead" ng-cloak>

    <div class="col-md-12">

    <div class="">
      
    <a class="btn btn-info btn-space" href="#" data-toggle="modal" data-target="#add_dialog">New Activity</a>

    </div>

    <div class="table-responsive">
      <table class="table">

        <tr>
          <th> ID </th>
          <th> Name </th>
          <th> Budget </th>
          <th> Sub Activities </th>
        </tr>

    <?php

    foreach ($functions->getAllActivities() as $key => $value) {
      
      echo "<tr>
      <td>".$value['activity_id']."</td>
      <td style='width:55%'>".$value['activity_name']."</td>
      <td>".$value['activity_id']."</td>
      <td><a href='#' class='sub_activities' ng-click='get_sub_activity(".$value['activity_table_id'].")' data-toggle='modal' data-target='#sub_activities'>Show</a> | 
      <a href='#' class='sub_activities' ng-click='get_sub_activity(".$value['activity_table_id'].")' data-toggle='modal' data-target='#add_sub_activity'>Add</a> | 
      <a href='activity_managment.php?activity_id_remove=".$value['activity_table_id']."' class='sub_activities'>Remove</a>

      </td>
      ";

    }

    ?>

        </table>
    </div>

    </div>

 <!-- Modal - New Activity -->

    <div class="modal fade" id="add_dialog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title modal-title-title">Add New Activity</h4>
                </div>
                
                <form class="form-horizontal" method="POST" action="activity_managment.php" style="margin-top: 20px">
       
                  <div class="form-group">
                  <label class="control-label col-sm-3" for="act_id">ID:</label>
                  <div class="col-sm-8">
                  <input type="text" class="form-control" name="act_id" placeholder="Enter the Activity ID. e.g Activity 1.1.1">
                  </div>
                  </div>

                  <div class="form-group">
                  <label class="control-label col-sm-3" for="act_title">Title:</label>
                  <div class="col-sm-8">
                  <input type="text" class="form-control" name="act_title" placeholder="Enter the Activity Title">
                  </div>
                  </div>

                  <div class="form-group">
                  <label class="control-label col-sm-3" for="act_budget">Budget:</label>
                  <div class="col-sm-8">
                  <input type="number" class="form-control" name="act_budget" placeholder="Enter the Activity Budget">
                  </div>
                  </div>

                  <div class="form-group">
                  <label class="control-label col-sm-3" for="act_start_date">Start Date:</label>
                  <div class="col-sm-8">
                  <input type="text" id="datepicker3" class="form-control" name="act_start_date" placeholder="Enter the Activity Start date">
                  </div>
                  </div>

                  <div class="form-group">
                  <label class="control-label col-sm-3" for="act_due_date">Due Date:</label>
                  <div class="col-sm-8">
                  <input type="text" id="datepicker4" class="form-control" name="act_due_date" placeholder="Enter the Activity Due Date">
                  </div>
                  </div>

                  <div class="form-group">
                  <label class="control-label col-sm-3" for="act_show_after">Show After:</label>
                  <div class="col-sm-8">
                  
                    <select class="form-control" id="sel1" name="act_show_after" style="height: 40px">

                    <?php


                      foreach ($functions->get_activity_show_after() as $key => $value) {
                        echo "<option value=".$value['activity_show_after'].">".$value['activity_id']."</option>";
                      }

                    ?>
           
                    </select>

                  </div>
                  </div>


                  <div class="row">
                    <button class="btn btn-space" name="new_activity">Save</button>
                  </div>
                </form>

                <div class="modal-footer">
                <p class="text-center">Learning for Life Project</p>
                </div>

            </div>
        </div>
    </div>

    <!-- END OF THE MODAL -->





    <!-- Modal - Update User details -->

    <div class="modal fade" id="sub_activities" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">

                <div class="modal-header header-color">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title modal-title-title" style="color: white"><b>Show Sub Activities</b></h4>
                </div>
                
                <div class="table-responsive" style="margin: 15px">
                <table class="table">
                  <tr>
                    <th>Title</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Budget</th>
                  </tr>

                  <tr ng-repeat="act in activitiesList | filter: filterbyId">
                    <td style="width: 40%">{{act.sub_activity_name}}</td>
                    <td>{{act.sub_activity_start_date}}</td>
                    <td>{{act.sub_activity_end_date}}</td>
                    <td>{{act.sub_activity_cost}}</td>

                  </tr>
                </table>
               </div>

                <div class="modal-footer">
                    <p class="text-center">Learning for Life Project</p>
                </div>

            </div>
        </div>
    </div>

    <!-- END OF THE MODAL -->


    <!-- Modal - Add Sub Activity -->

    <div class="modal fade" id="add_sub_activity" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header header-color">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title modal-title-title" style="color: white"><b>Add Sub Activity</h4></b>
                </div>
                
                <form class="form-horizontal" method="post" action="activity_managment.php" style="margin-top: 20px">
       
                  <div class="form-group">
                  <label class="control-label col-sm-3" for="act_id">ID:</label>
                  <div class="col-sm-8">
                  <input type="text" class="form-control" name="new_act_id" value="{{activity_val}}" readonly="readonly" />
                  </div>
                  </div>

                  <div class="form-group">
                  <label class="control-label col-sm-3" for="new_act_title">Title:</label>
                  <div class="col-sm-8">
                  <input type="text" class="form-control" name="new_act_title" placeholder="Enter the Activity Title" required />
                  </div>
                  </div>

                  <div class="form-group">
                  <label class="control-label col-sm-3" for="new_act_budget">Budget:</label>
                  <div class="col-sm-8">
                  <input type="number" class="form-control" name="new_act_budget" placeholder="Enter the Activity Budget">
                  </div>
                  </div>

                  <div class="form-group">
                  <label class="control-label col-sm-3" for="new_act_start_date">Start Date:</label>
                  <div class="col-sm-8">
                  <input type="text" id="datepicker1" class="form-control" name="new_act_start_date" placeholder="Enter the Activity Start date">
                  </div>
                  </div>

                  <div class="form-group">
                  <label class="control-label col-sm-3" for="new_act_due_date">Due Date:</label>
                  <div class="col-sm-8">
                  <input type="text" id="datepicker2" class="form-control" name="new_act_due_date" placeholder="Enter the Activity Due Date">
                  </div>
                  </div>


                  <div class="row">
                    <button class="btn btn-space" name="new_sub_activity">Save</button>
                  </div>
                </form>

                <div class="modal-footer">
                <p class="text-center">Learning for Life Project</p>
                </div>

            </div>
        </div>
    </div>

    <!-- END OF THE MODAL -->




    </div>
    </div>
    </div>



<?php require_once "footer.php"; ?>
<script src="https://ajax.googleapis.com/ajax/libs/angular_material/1.1.0/angular-material.min.js"></script>
<script>

var app = angular.module('myModule', ['xeditable'])
app.controller('ctrlRead', ['$scope', '$http', function ($scope, $http) {


    var request2 = $http({
      method: "get",
      url : "activities.json"
    });

    request2.then(function(response){
      $scope.activities = response.data;
    });





        var request3 = $http({
      method: "get",
      url : "activitiesList.json"
    });

    request3.then(function(response){
      $scope.activitiesList = response.data;
    });




    $scope.get_sub_activity = function(val){

      $scope.activity_val = val;

    }


    $scope.filterbyId = function (item) { 
      if(item === 2){
        
      }
     

};



}]);


</script>


<?php

if(isset($_POST['new_sub_activity'])){

  $sub_activity_id = $_POST['new_act_id'];

  $sub_activity_name = $_POST['new_act_title'];
  $sub_activity_start = $_POST['new_act_start_date'];
  $sub_activity_end = $_POST['new_act_due_date'];
  $sub_activity_budget = $_POST['new_act_budget'];
  $sub_activity_desc = $_POST['new_act_desc'];

  $functions->add_new_sub_activity($sub_activity_id, $sub_activity_name, $sub_activity_start, $sub_activity_end, $sub_activity_budget, $sub_activity_desc);

}



if(isset($_POST['new_activity'])){

  $sub_activity_id = $_POST['act_id'];
  $sub_activity_name = $_POST['act_title'];
  $sub_activity_start = $_POST['act_start_date'];
  $sub_activity_end = $_POST['act_due_date'];
  $sub_activity_budget = $_POST['act_budget'];
  $act_show_after = $_POST['act_show_after'];

  $functions->add_new_activity($sub_activity_id, $act_show_after, $sub_activity_name, $sub_activity_start, $sub_activity_end, $sub_activity_budget);

}



if(isset($_GET['activity_id_remove'])){

  $activity_delete = $_GET['activity_id_remove'];

  $functions->activity_id_remove($activity_delete);

}


?>



