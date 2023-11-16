<?php

require_once "/includes/function.php";
require_once "db.php";
require_once "query_functions.php";
require_once "header.php";

$functions = new query_functions();

?>

<div ng-app="myApp" ng-controller="myCtrl">
    <select data-ng-model="firstSelect" data-ng-options="option.id as option.name for option in parentOptionObjs"></select>
    <select data-ng-model="secondSelect" data-ng-options="option.name for option in childOptionObjs | secondDropdown: firstSelect"></select>
</div>

<?php require_once 'footer.php'; ?>

<script>

var app = angular.module('myApp', []);
app.controller('myCtrl', ['$scope','$http', function ($scope,$http) {
  // This controller throws an unknown provider error because
  // a scope object cannot be injected into a service.
  var request2 = $http({
      method: "get",
      url : "person.json"
  });

  request2.then(function(response){
      $scope.items = response.data;
  });

    $scope.parentOptionObjs = [{
        id: 1,
        name: 'option 1',
        desc: ''
    }, {
        id: 2,
        name: 'option 2',
        desc: ''
    }];

    $scope.childOptionObjs = [{
        parent: 1,
        id: 9,
        name: 'option 11',
        desc: ''
    }, {
        parent: 1,
        id: 10,
        name: 'option 12',
        desc: ''
    }, {
        parent: 1,
        id: 11,
        name: 'option 13',
        desc: ''
    }, {
        parent: 2,
        id: 12,
        name: 'option 14',
        desc: ''
    }, {
        parent: 2,
        id: 13,
        name: 'option 15',
        desc: ''
    }];


    app.filter('secondDropdown', function () {
        return function (secondSelect, firstSelect) {
            var filtered = [];
            if (firstSelect === null) {
                return filtered;
            }
            angular.forEach(secondSelect, function (s2) {
                if (s2.parent == firstSelect) {
                    filtered.push(s2);
                }
            });
            return filtered;
        };
    });
}]);

</script>
