<!DOCTYPE html>
<html>
<head>

	<?php require_once "header.php"; ?>

	<title></title>
</head>
<body>

	<div ng-app="myapp">
  <div ng-controller="ctrlRead">
    <div class="container">

      <label>Type:</label>
      <ui-select multiple ng-model="selected.items" theme="bootstrap">
        <ui-select-match placeholder="Select colors...">{{$item}}</ui-select-match>
        <ui-select-choices repeat="type in types">
          <div ng-bind="type | highlight: $select.search"></div>
        </ui-select-choices>
      </ui-select>
      
      <label>Country:</label>
      <ui-select multiple ng-model="selected.country" ng-change="getCityList()" theme="bootstrap">
        <ui-select-match placeholder="Select country...">{{$item}}</ui-select-match>
        <ui-select-choices repeat="coun in country">
          <div ng-bind="coun | highlight: $select.search"></div>
        </ui-select-choices>
      </ui-select>
      
      <label>City:</label>
      <ui-select multiple ng-model="selected.city" theme="bootstrap">
        <ui-select-match placeholder="Select city...">{{$item}}</ui-select-match>
        <ui-select-choices repeat="stat in city">
          <div ng-bind="stat | highlight: $select.search"></div>
        </ui-select-choices>
      </ui-select>

      <table class="table">
        <tr>
          <th>#</th>
          <th>Name</th>
          <th>Type</th>
          <th>Country</th>
          <th>City</th>
        </tr>

        <tr ng-repeat="item in samples | filter:customFilter | filter:customFilterCountry | filter:customFilterCity" >
          <td>{{item.id}}</td>
          <td>{{item.name}}</td>
          <td>{{item.type}}</td>
          <td>{{item.country}}</td>
          <td>{{item.city}}</td>
        </tr>


</body>
</html>

<?php require_once "footer.php"; ?>

<script type="text/javascript">
		
var modules = angular.module('myapp', ['angular.filter', 'ui.select']);
modules.controller('ctrlRead', ['$scope', '$http', '$filter',
  function($scope, $http ,$filter) {



 var request2 = $http({
            method: "get",
            url : "json/test.json"
        });

        request2.then(function(response){
            $scope.samples = response.data;
        });




    $scope.selected = {
      items: [],
      city:[],
      country:[]
    }




    
    $scope.getCityList=function(){
    var sampletemp = [];
    $scope.selected.country.forEach(function(country) {
	var temp = 	objectFromArrayFilter($scope.samples,'country',country);
	sampletemp = sampletemp.concat(temp);
	});

    $scope.uniquecity = $filter('unique')(sampletemp, 'city');
    $scope.selected.city= [];
    $scope.city = $scope.uniquecity.map(function(item) {
    return item.city
    })
    }



    $scope.customFilter = function(obj) {
      if (!$scope.selected.items.length) return true
      return $scope.selected.items.indexOf(obj.type) > -1
    }
    
    $scope.customFilterCity = function(obj) {
      if (!$scope.selected.city.length) return true
      return $scope.selected.city.indexOf(obj.city) > -1
    }
    
    $scope.customFilterCountry = function(obj) {
      if (!$scope.selected.country.length) return true
      return $scope.selected.country.indexOf(obj.country) > -1
    }



	$scope.uniquetypes = $filter('unique')($scope.samples, 'type');
    $scope.types = $scope.uniquetypes.map(function(item) {
      return item.type
    })
    
    $scope.uniquecountry = $filter('unique')($scope.samples, 'country');
    $scope.country = $scope.uniquecountry.map(function(item) {
      return item.country
    })
    
    $scope.uniquecity = $filter('unique')($scope.samples, 'city');
    $scope.city = $scope.uniquecity.map(function(item) {
      return item.city
    })
  
	var objectFromArrayFilter=function(arrayOptions, key, value) {
				var filterResult = arrayOptions.filter(function(val) {
							return val[key] === value;
				});
		return filterResult;
	};

  }
]);

</script>