var modules = angular.module('myapp', ['angular.filter', 'ui.select']);
modules.controller('ctrlRead', ['$scope', '$filter',
  function($scope, $filter) {

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


    
    $scope.customFilterCountry = function(obj) {
      if (!$scope.selected.country.length) return true
      return $scope.selected.country.indexOf(obj.country) > -1
    }

    $scope.samples = [{
      id: 1,
      name: "Justin",
      type: "Average",
      country: "United State",
      city: "Dallas"
    }, {
      id: 2,
      name: "Alex",
      type: "Average",
      country: "United State",
      city: "Dallas"
    }, {
      id: 3,
      name: "Mia",
      type: "Medium",
      country: "England",
      city: "London"
    }, {
      id: 4,
      name: "Sasha",
      type: "Top",
      country: "United State",
      city: "Addison"
    }, {
      id: 5,
      name: "Eric",
      type: "Top",
      country: "United State",
      city: "Irving"
    }, {
      id: 6,
      name: "Taz",
      type: "Average",
      country: "England",
      city: "Manchester"
    }, {
      id: 7,
      name: "Normai",
      type: "Low",
      country: "United State",
      city: "Richardson"
    }];


    
    $scope.uniquecountry = $filter('unique')($scope.samples, 'country');
    $scope.country = $scope.uniquecountry.map(function(item) {
      return item.country
    })
    

	var objectFromArrayFilter=function(arrayOptions, key, value) {
				var filterResult = arrayOptions.filter(function(val) {
							return val[key] === value;
				});
		return filterResult;
	};

  }
]);
