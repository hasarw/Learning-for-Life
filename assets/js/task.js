
var app = angular.module('taskModule', [])


app.filter('taskPriority', function() {

  return function(num) {
    if(num == 1){
      return 'Urgent';
    }
     if(num == 2){
      return 'High';
    }
     if(num == 3){
      return 'Medium';
    }
     if(num == 4){
      return 'Low';
    }
  };

});



app.controller('ctrlTask', ['$scope','$filter' ,'$http', function ($scope, $filter, $http) {

        var request2 = $http({
            method: "get",
            url : "task.json"
        });

        request2.then(function(response){
            $scope.tasks = response.data;
        });

  $scope.task_details = function(details) {

    return $scope.task_details_text = details;


  }





}]);