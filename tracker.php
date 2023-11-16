<?php

require_once "/includes/function.php";
require_once "db.php";
require_once "query_functions.php";
require_once "header.php";

$functions = new query_functions();

$functions->getTrackerActivity();

?>

    <div class="container">

    <div class="row" ng-app="myModule">
    <div id="container" ng-controller="ctrlRead" ng-cloak>
    <div class="col-md-12">

    <a href="activity_managment.php" class="btn btn-info" style="margin: 20px">Activity Management</a>

    <div id="example5.1" style="height: 550px;">
      
    </div>
    </div>


     <!-- Modal - Update User details -->
    <div class="modal fade" id="add_dialog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title modal-title-title">{{activity_title}}</h4>
                </div>
                    <div class="col-md-12">
                    <br/>
   
                    <button class='btn btn-sm btn-info' ng-click="findValue()" data-toggle='collapse' id='menu-toggle-1' data-target='#show'>Details</button>

                    <p class="text collapse" id="show" >
                    <br/>
                      Activity ID: <b>{{activity_num}}</b><br/>

                      Activity name: <b>{{activity_title}}</b><br/>

                      Total Budget: <a href="#" editable-text="activity_cost"
                      onbeforesave="updateBudgetData($data,activity_tracker_id)">{{ activity_cost || "empty" }} </a><br/>

                      Spend: <a href="#" editable-text="activity_percent"
                      onbeforesave="updateUser($data,activity_tracker_id)">{{ activity_percent || "empty" }} </a><br/>

                      Completed: <b>{{activity_spend | number:2}} % </b><br/>

                      Description: <b>{{activity_desc}}</b><br/>

                      Start Date: <a href="#" editable-combodate="activity_start_date" onbeforesave="updateStartDate($data,activity_tracker_id)">
                      {{ (activity_start_date | date:"") || 'empty' }}
                      </a><br/>

                      Due Date: <a href="#" editable-combodate="activity_end_date" onbeforesave="updateEndDate($data,activity_tracker_id)">
                      {{ (activity_end_date | date:"") || 'empty' }}
                      </a><br/>

                    </p>
                    </div>

                <div class="modal-footer">
                <p class="text-center">Learning for Life Project</p>
                </div>

            </div>
        </div>
    </div>
    <!-- // Modal -->

    </div>
    </div>
    </div>



<?php require_once "footer.php"; ?>


<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script>

var fessmodule = angular.module('myModule', ['xeditable'])
fessmodule.controller('ctrlRead', ['$scope', '$http', function ($scope, $http) {

   angular.element(document).ready(function () {

    var request2 = $http({
      method: "get",
      url : "activities.json"
    });

    request2.then(function(response){
      $scope.activities = response.data;
    });

//////////////////////////////////////////////////
    
    $scope.updateBudgetData = function(name,id) { 

    $http.post("tracker_change_activity_budget.php",{'id': id, 'spend': name})
    .then(function(){
      alert('Data Sended !');
    });
    };


    $scope.updateUser = function(name,id) { 

    $http.post("tracker_change_activity_name.php",{'id': id, 'spend': name})
    .then(function(){
      alert('Data Sended !');
    });
    };


    $scope.updateStartDate = function(name,id) { 

    $http.post("tracker_change_activity_startdate.php",{'id': id, 'spend': name})
    .then(function(){
      alert('Data Sended !');
    });
    };


    $scope.updateEndDate = function(name,id) { 

    $http.post("tracker_change_activity_enddate.php",{'id': id, 'spend': name})
    .then(function(){
      alert('Data Sended !');
    });
    };


//////////////////////////////////////////////////

  $scope.findValue = function(abc) {

    $scope.val = abc;

    // alert($scope.val + 'asdas');

    angular.forEach($scope.activities, function(value, key) {
    if (value.sub_activity_id === $scope.val) {
            $scope.activity_tracker_id = value.sub_activity_id;

            $scope.activity_title = value.act_name;
            $scope.activity_desc = value.sub_activity_desc;

            $scope.activity_num = value.activity_id;

            $scope.activity_start_date = value.startdate;
            $scope.activity_end_date = value.enddate;


            $scope.activity_cost = value.sub_activity_cost;

            $scope.activity_percent = value.sub_activity_percent;

            var a = $scope.activity_percent;

              $scope.activity_spend = (($scope.activity_percent * 100)/$scope.activity_cost);
        
            // $scope.activity_spend = parseFloat(Math.round(a * 100) / 100).toFixed(2);

            }
    });

}


  google.charts.load("current", {packages:["timeline"]});
  google.charts.setOnLoadCallback(drawChart);
  function drawChart() {

    var container = document.getElementById('example5.1');
    var chart = new google.visualization.Timeline(container);
    var dataTable = new google.visualization.DataTable();

    dataTable.addColumn({ type: 'string', id: 'Room' });
    dataTable.addColumn({ type: 'string', id: 'Name' });
    dataTable.addColumn({ type: 'date', id: 'Start' });
    dataTable.addColumn({ type: 'date', id: 'End' });

    dataTable.addRows([

      <?php

         foreach ($functions->get_sub_activity_details() as $key => $value) {

            $start_date = $value['sub_activity_start_date'];

            if($start_date == ''){
              $start_date = '2016,10,01';
            }else{
              $start_date = date("Y,m,d", strtotime($start_date));
            }


            $end_date = $value['sub_activity_end_date'];
           
            if($end_date == ''){
              $end_date = '2016,10,01';
            }else{
              $end_date = date("Y,m,d", strtotime($end_date));
            }

            $activity_id = $value['activity_id'];

            $activity_table_id = $value['sub_activity_id'];




            echo "[ '".$activity_id."', '".$activity_table_id."', new Date(".$start_date."), new Date(".$end_date.") ],";

          }

      ?>

      ]);

    var options = {
      timeline: { colorByRowLabel: true }
    };

    google.visualization.events.addListener(chart, 'select', function () {
    var selection = chart.getSelection();
    if (selection.length > 0) {
    var abc = dataTable.getValue(selection[0].row, 1);

    $scope.variable = abc;
    $scope.findValue(abc);


    $('#add_dialog').modal('show');

    $('#add_dialog').on('hidden.bs.modal', function () {
    location.reload();
    });

}

});

    chart.draw(dataTable, options);
  }

});

}]);

fessmodule.run(function(editableOptions) {
  editableOptions.theme = 'bs3'; // bootstrap3 theme. Can be also 'bs2', 'default'
});

</script>