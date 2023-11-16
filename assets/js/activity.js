   
var mod = angular.module("MyApp", ['xeditable','chart.js']);

mod.run(function(editableOptions) {
  editableOptions.theme = 'bs3'; // bootstrap3 theme. Can be also 'bs2', 'default'
});



mod.controller('myCtrl', ['$scope', '$http', function ($scope, $http) {

///////////////////////////////////////////////////////////////////////////////

      var request2 = $http({
      method: "get",
      url : "json/activity_details.json"
      });

      request2.then(function(response){
      $scope.activities = response.data;
      });

////////////////////////////////////////////////////////////////////////////////

      var getActivityDetails = $http({
      method: "get",
      url : "json/sub_activities.json"
      });

      getActivityDetails.then(function(response){
      $scope.sub_activities = response.data;
      });

/////////////////////////////////////////////////////////////////////////////////
      
      var getAllItt = $http({
      method: "get",
      url : "json/select_all_itt.json"
      });

      getAllItt.then(function(response){
      $scope.select_all_itt = response.data;
      });

///////////////////////////////////////////////////////////////////////////////



///////////////////////////////////////////////////////////////////////////////

    $scope.showActivities = function(name) { 

      $scope.act_id = '';
      // $scope.act_id_num = '';
      $scope.act_name = '';
      $scope.act_desc = '';
      $scope.act_start_date = '';
      $scope.act_due_date = ''; 
      $scope.act_budget = '';
      $scope.act_spend = '';
      $scope.act_color = '';
      $scope.act_complete = '';

      angular.forEach($scope.activities, function(value){
      
      if(value.test_id_num == name){

        // clean anything first

      $scope.act_id = '';
      $scope.act_id_num = '';
      $scope.act_name = '';
      $scope.act_desc = '';
      $scope.act_start_date = '';
      $scope.act_due_date = ''; 
      $scope.act_budget = '';
      $scope.act_spend = '';
      $scope.act_color = '';
      $scope.act_complete = '';

      // assign variables then

      $scope.act_id = value.test_id;
      $scope.act_id_num = value.test_id_num;
      $scope.act_name = value.test_title;
      $scope.act_desc = value.test_desc;
      $scope.act_start_date = value.test_start_date;
      $scope.act_due_date = value.act_due_date; 
      $scope.act_budget = value.act_budget;
      $scope.act_spend = value.act_spend;
      $scope.act_color = value.test_color;


      var myEl = angular.element( document.querySelector( '#act_complete' ) );
      myEl.html((value.act_spend * 100)/value.act_budget+' %'); 

      $scope.act_complete = $filter('number')(value.act_spend, 2);

      myE1.html(act_complete);
      
      }else{
        var myEl = angular.element( document.querySelector( '#act_id_num' ) );
      myEl.val(name);
      
      }

      });
  
    };

//// another function for activities details ///////////////////////////////////
    
    

      $scope.clean_form_activity = function() { 

    
      $scope.act_name = '';
      $scope.act_desc = '';
      $scope.act_start_date = '';
      $scope.act_due_date = ''; 
      $scope.act_budget = '';
      $scope.act_spend = '';
      $scope.act_color = '';

      var myEl = angular.element( document.querySelector( '#act_complete' ) );
      myEl.html(''); 

      // $scope.act_complete = $filter('number')(value.act_spend, 2);

    };


////////////////////////////////////////////////////////////////////////////////


    $scope.activitiesModal = function(num) { 

      //Target
      //Achivemnt
      //Varience

        $scope.activity_title = '';
        $scope.activity_start_date = '';
        $scope.activity_due_date = '';
        $scope.activity_target = '';
        $scope.activity_achievement = '';
        $scope.activity_varience = '';
        $scope.activity_description = '';


      angular.forEach($scope.sub_activities, function(value){
      
      if(value.id == num){

      // assign variables then

        $scope.act_id_2 = value.id;
        $scope.activity_title = value.title;

        $scope.activity_output = value.output_desc;
        $scope.activity_outcome = value.outcome_desc;

        $scope.activity_start_date = value.start_date;
        $scope.activity_due_date = value.end_date;
        // $scope.activity_target = value.target;
        // $scope.activity_achievement = value.achievement;
        // $scope.activity_varience = value.variance;
        $scope.activity_description = value.description;

      }

      });

    };

//// Toggle for Button Text Onclick ///////////////////////////////////////////////////

 $scope.showDetails = false;
    
    $scope.$watch('showDetails', function(){
        $scope.toggleText = $scope.showDetails ? 'ITT List' : 'New Quarter';
    })

//Insert New Quarter in ITT Table /////////////////////////////////////////////////////

$scope.submit_new_itt = function(val_1,val_2,val_3) {

      $http({
      method: 'POST',
      url: 'activity/insert_itt.php',
      headers: {'Content-Type': 'application/x-www-form-urlencoded'},

      data: {target: val_1, achievement: val_2, act_id: val_3}
      }).then(function () {

      });

};


////////////////////////////////////////////////////////////////////////////////////////

 $scope.updateTarget = function(id, name) { 



      $http({
      method: 'POST',
      url: 'activity/changeTarget.php',
      headers: {'Content-Type': 'application/x-www-form-urlencoded'},

      data: {id: id, target: name}
      }).then(function () {

      });

    };
    
////////////////////////////////////////////////////////////////////////////////////////

 $scope.updateAchieve = function(id, name) { 
 
    $http({
      method: 'POST',
      url: 'activity/updateAchieve.php',
      headers: {'Content-Type': 'application/x-www-form-urlencoded'},

      data: {id: id, achieve: name}
      }).then(function () {

      });

    };

////////////////////////////////////////////////////////////////////////////////////////

  $scope.delete_itt = function(id) { 
  
    $http({
      method: 'POST',
      url: 'activity/delete_itt.php',
      headers: {'Content-Type': 'application/x-www-form-urlencoded'},

      data: {id: id}
      }).then(function () {

        location.reload('activity_new.php');

      });

    };




///////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////
/// removeActivity ////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////



  $scope.removeActivity = function(id) { 

    $http({
      method: 'POST',
      url: 'activity/remove_Activity.php',
      headers: {'Content-Type': 'application/x-www-form-urlencoded'},

      data: {id: id}
      }).then(function () {

        location.reload('activity_new.php');

      });
    };

//////////////////////////////////////////////////////////////////////////////////////

$scope.new_output_insertion = function(outcome_id, output_desc) { 


    $http({
      method: 'POST',
      url: 'activity/add_output.php',
      headers: {'Content-Type': 'application/x-www-form-urlencoded'},

      data: {id: outcome_id, name: output_desc}
      }).then(function () {

        location.reload('activity_new.php');

      });
    };



/////////////////////////////////////////////////////////////////////////////////////

$scope.remove_output = function(id) { 


    $http({
      method: 'POST',
      url: 'activity/remove_output.php',
      headers: {'Content-Type': 'application/x-www-form-urlencoded'},

      data: {id: id}
      }).then(function () {

        location.reload('activity_new.php');

      });
    };

/////////////////////////////////////////////////////////////////////////////////////

$scope.new_outcome_insertion = function(output_desc) { 
   
    $http({
      method: 'POST',
      url: 'activity/add_outcome.php',
      headers: {'Content-Type': 'application/x-www-form-urlencoded'},

      data: {name: output_desc}
      }).then(function () {

        location.reload('activity_new.php');

      });
    };



/////////////////////////////////////////////////////////////////////////////////////

$scope.remove_outcome = function(id) { 


    $http({
      method: 'POST',
      url: 'activity/remove_outcome.php',
      headers: {'Content-Type': 'application/x-www-form-urlencoded'},

      data: {id: id}
      }).then(function () {

        location.reload('activity_new.php');

      });
    };

/////////////////////////////////////////////////////////////////////////////////////


}]);