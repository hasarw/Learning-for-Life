<!DOCTYPE html>
<html>
<head>
  <title>Test Page</title>
</head>
<body>


<div ng-app="myapp">
<div ng-controller="ctrlRead">
<div class="container" ng-cloak>



<table class="table">
  <tr>
    <th>#</th>
    <th>Name</th>
    <th>Type</th>
    <th>City</th>
  </tr>

  <tr ng-repeat="item in samples">
    <td>{{item.id}}</td>
    <td>{{item.name}}</td>
    <td>{{item.type}}</td>
    <td>{{getCity(item.city)}}</td>
  </tr>
</table>

</div>
</div>
</div>



</body>
</html>


<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.6/angular.min.js"></script>
<script type="text/javascript">
 

var modules = angular.module('myapp', []);
modules.controller('ctrlRead', ['$scope', function ($scope) {



$scope.samples = [
{id: 1, name: "alex", type: "Average", city: 12},
{id: 2, name: "Alex", type: "Average", city: 12},
{id: 3, name: "Mia", type: "Medium", city: 13},
{id: 4, name: "Sasha", type: "Top", city: 14},
{id: 5, name: "Eric", type: "Top", city: 12},
{id: 6, name: "Taz", type: "Average", city: 14},
{id: 7, name: "Normai", type: "Low", city: 13},
{id: 8, name: "Jim", type: "Average", city: 11}];


$scope.city = [
{id: 11, name: "Dallas"},
{id: 12, name: "Los Angeles"},
{id: 13, name: "New York"},
{id: 14, name: "Washington"}
];

$scope.getCity = function(name) { 
   debugger;
  $scope.city_name = "";
  angular.forEach($scope.city, function(value, key){
      
      if(value.id == name){
        $scope.city_name = value.name;
      }
      
     

      });
  return $scope.city_name;
}

}]);



</script>