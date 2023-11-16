var fessmodule = angular.module('myModule', ['rzModule', 'angularUtils.directives.dirPagination','angular.filter', 'ui.select'])

fessmodule.filter('genderFilter', function() {

  return function(num) {
    if(num == 1){
      return 'Male';
    }else{
      return 'Female';
    }
  };

});


fessmodule.controller('ctrlRead', ['$scope','$filter' ,'$http', function ($scope, $filter, $http) {

         $scope.selected = {
         province: [],
         district:[],
         village:[],
         type:[],
         items: [],
         filtered: []
        }


        $scope.selected.gender = [];


 var request2 = $http({
            method: "get",
            url : "person.json"
        });

        request2.then(function(response){
            $scope.items = response.data;
        });

angular.element(document).ready(function(){

        $scope.getDistrictList=function(){
        var sampletemp = [];
        $scope.selected.province.forEach(function(beneficiary_province) {
        var temp =  objectFromArrayFilter($scope.items,'beneficiary_province',beneficiary_province);
        sampletemp = sampletemp.concat(temp);
        });
        $scope.uniquedistrict = $filter('unique')(sampletemp, 'beneficiary_district');
        $scope.selected.district= [];
        $scope.district = $scope.uniquedistrict.map(function(item) {
        return item.beneficiary_district
        })
        }


       $scope.getVillageList=function(){
       var sampletemp = [];
       $scope.selected.district.forEach(function(beneficiary_district) {
       var temp =   objectFromArrayFilter($scope.items,'beneficiary_district',beneficiary_district);
       sampletemp = sampletemp.concat(temp);
       });
       $scope.uniquevillage = $filter('unique')(sampletemp, 'beneficiary_village');
       $scope.selected.village= [];
       $scope.village = $scope.uniquevillage.map(function(item) {
       return item.beneficiary_village
       })
       }


       $scope.getProvinceByDistrict=function(){
      var sampletemp = [];
      $scope.selected.district.forEach(function(beneficiary_district) {
    var temp =  objectFromArrayFilter($scope.items,'beneficiary_district',beneficiary_district);
    sampletemp = sampletemp.concat(temp);
            });
      $scope.uniqueprovince = $filter('unique')(sampletemp, 'beneficiary_province');
        $scope.selected.province= [];

       $scope.province = $scope.uniqueprovince.map(function(item) {
      return item.beneficiary_province
        })
      $scope.selected.province=$scope.province;

      if($scope.province.length == 0){

        $scope.uniqueprovince = $filter('unique')($scope.items, 'beneficiary_province');
        $scope.province = $scope.uniqueprovince.map(function(item) {
        return item.beneficiary_province
        })
      }
    }


    $scope.getDistrictByVillage=function(){
   var sampletemp = [];
   $scope.selected.village.forEach(function(beneficiary_village) {
 var temp =  objectFromArrayFilter($scope.items,'beneficiary_village',beneficiary_village);
 sampletemp = sampletemp.concat(temp);
         });
   $scope.uniquedistrict = $filter('unique')(sampletemp, 'beneficiary_district');
     $scope.selected.district= [];

    $scope.district = $scope.uniquedistrict.map(function(item) {
   return item.beneficiary_district
     })
   $scope.selected.district=$scope.district;

   if($scope.district.length == 0){

     $scope.uniquedistrict = $filter('unique')($scope.items, 'beneficiary_district');
     $scope.district = $scope.uniquedistrict.map(function(item) {
     return item.beneficiary_district
     })
   }


   var sampletemp = [];
   $scope.selected.district.forEach(function(beneficiary_district) {
 var temp =  objectFromArrayFilter($scope.items,'beneficiary_district',beneficiary_district);
 sampletemp = sampletemp.concat(temp);
         });
   $scope.uniqueprovince = $filter('unique')(sampletemp, 'beneficiary_province');
     $scope.selected.province= [];

    $scope.province = $scope.uniqueprovince.map(function(item) {
   return item.beneficiary_province
     })
   $scope.selected.province=$scope.province;

   if($scope.province.length == 0){

     $scope.uniqueprovince = $filter('unique')($scope.items, 'beneficiary_province');
     $scope.province = $scope.uniqueprovince.map(function(item) {
     return item.beneficiary_province
     })
   }

 }


$scope.customFilterProvince = function(obj) {
  if (!$scope.selected.province.length) return true
  return $scope.selected.province.indexOf(obj.beneficiary_province) > -1
}

$scope.customFilterDistrict = function(obj) {
  if (!$scope.selected.district.length) return true
  return $scope.selected.district.indexOf(obj.beneficiary_district) > -1
}

$scope.customFilterVillage = function(obj) {
  if (!$scope.selected.village.length) return true
  return $scope.selected.village.indexOf(obj.beneficiary_village) > -1
}

$scope.customFilter = function(obj) {
  if (!$scope.selected.items.length) return true
  return $scope.selected.items.indexOf(obj.telecom_number) > -1
}

$scope.customFilterType = function(obj) {
  if (!$scope.selected.type.length) return true
  return $scope.selected.type.indexOf(obj.beneficiary_type) > -1
}

$scope.customFilterGender = function(obj) {
  if (!$scope.selected.gender.length) return true
  return $scope.selected.gender.indexOf(obj.beneficiary_gender) > -1
}

$scope.ageRate = "";

$scope.byRange = function (minValue, maxValue) {

  if (minValue === undefined) minValue = Number.MIN_VALUE;
  if (maxValue === undefined) maxValue = Number.MAX_VALUE;

  return function predicateFunc(item) {
    return $scope.ageRate = minValue <= item.beneficiary_age && item.beneficiary_age <= maxValue;
  };
};



//Added for Select UI



angular.element(document).ready(function(){

  $scope.uniquetypes = $filter('unique')($scope.items, 'telecom_number');
  $scope.types = $scope.uniquetypes.map(function(item) {
    return item.telecom_number
  })

  $scope.uniqueprovince = $filter('unique')($scope.items, 'beneficiary_province');
  $scope.province = $scope.uniqueprovince.map(function(item) {
    return item.beneficiary_province
  })

  $scope.uniquedistrict = $filter('unique','filter:$selected.province')($scope.items, 'beneficiary_district');
  $scope.district = $scope.uniquedistrict.map(function(item) {
    return item.beneficiary_district
  })

  $scope.uniquevillage = $filter('unique')($scope.items, 'beneficiary_village');
  $scope.village = $scope.uniquevillage.map(function(item) {
    return item.beneficiary_village
  })

  $scope.uniquegender = $filter('unique')($scope.items, 'beneficiary_gender');
  $scope.gender = $scope.uniquegender.map(function(item) {
    return item.beneficiary_gender
  })


  $scope.uniquetype = $filter('unique')($scope.items, 'beneficiary_type');
  $scope.type = $scope.uniquetype.map(function(item) {
    return item.beneficiary_type
  })





  });


 });



$scope.update = function(id){
    window.reload();
 };


$scope.printFunction = function(){

  $(".table").removeClass("tableScroll");
  print();
  $(".table").addClass("tableScroll");

}


$scope.rowCount = function(){
  var rowCount = $('.table tr').length;
  return rowCount - 2;
};



$scope.rowCountTotal = function(district){
  var counter = '';
  var population = 0;
  angular.forEach(district, function(value){
    // counter = value;
    counter = $scope.items.filter(item => (item.beneficiary_province === value));
    population += counter.length;
   });
return population;
}

$scope.rowCountDistrict = function(district){
  var counter = '';
  var population = 0;
  angular.forEach(district, function(value){
    // counter = value;
    counter = $scope.items.filter(item => (item.beneficiary_district === value));
    population += counter.length;

   });
return population;
}

$scope.rowCountVillage = function(district){
  var counter = '';
  var population = 0;
  angular.forEach(district, function(value){
    // counter = value;
    counter = $scope.items.filter(item => (item.beneficiary_village === value));
    population += counter.length;

   });
return population;
}

$scope.rowCountGenderMaleDistrict = function(district){
  var counter = '';
  var population = 0;
  angular.forEach(district, function(value){
    // counter = value;
    counter = $scope.items.filter(item => (item.beneficiary_gender === "1") && (item.beneficiary_district === value));
    population += counter.length;

   });
return population;
}

// for counting Females in district
$scope.rowCountGenderFemaleDistrict = function(district){
  var counter = '';
  var population = 0;
  angular.forEach(district, function(value){
    // counter = value;
    counter = $scope.items.filter(item => (item.beneficiary_gender === "2") && (item.beneficiary_district === value));
    population += counter.length;

   });
return population;
}


// for counting Male in district
$scope.rowCountGenderMaleVillage = function(district){
  var counter = '';
  var population = 0;
  angular.forEach(district, function(value){
    // counter = value;
    counter = $scope.items.filter(item => (item.beneficiary_gender === "2") && (item.beneficiary_village === value));
    population += counter.length;

   });
return population;
}


// for counting Females in village
$scope.rowCountGenderFemaleVillage = function(district){
  var counter = '';
  var population = 0;
  angular.forEach(district, function(value){
    // counter = value;
    counter = $scope.items.filter(item => (item.beneficiary_gender === "1") && (item.beneficiary_village === value));
    population += counter.length;

   });
return population;
}


$scope.rowCountGenderFemale = function(district){
  var filtered = $scope.items.filter(item => (item.beneficiary_gender === "Female") && (item.beneficiary_district == district));
  return filtered.length;

};


$scope.counterTable = function (minValue, maxValue) {

    if (minValue === undefined) minValue = Number.MIN_VALUE;
    if (maxValue === undefined) maxValue = Number.MAX_VALUE;

    var filtered = $scope.items.filter(item => (minValue <= item.beneficiary_age) && (item.beneficiary_age <= maxValue));
    return filtered.length;

};




// for counting table after range



  $scope.resetForm = function() {
    $scope.selected.province = {};
    $scope.selected.district = {};
    $scope.selected.village = {};
    $scope.selected.type = {};
    $scope.selected.gender = {};
    $scope.selected.items = {};
    $scope.slider = {
    minValue: 15,
    maxValue: 65,
    options: {
    floor: 10,
    ceil: 80,
    showTicksValues: 10
  }
};
};



$scope.sort = function(keyname){
  $scope.sortKey = keyname;
  $scope.reverse = !$scope.reverse;
};


$scope.showAll = function (){
  $scope.counter = 1000;
}


$scope.getTotal = function(){
    var total = 0;
    for(var i = 0; i < $scope.items.length; i++){
        var product = $scope.items[i];
        total += 1;
    }
    return total;
}


$scope.slider = {
    minValue: 15,
    maxValue: 65,
    options: {
    floor: 10,
    ceil: 80,
    showTicksValues: 10
  }
};




var objectFromArrayFilter=function(arrayOptions, key, value) {
        var filterResult = arrayOptions.filter(function(val) {
              return val[key] === value;
        });
    return filterResult;
  };






}]);


// app.filter('secondDropdown', function () {
//     return function (secondSelect, firstSelect) {
//         var filtered = [];
//         if (firstSelect === null) {
//             return filtered;
//         }
//         angular.forEach(secondSelect, function (s2) {
//             if (s2.parent == firstSelect) {
//                 filtered.push(s2);
//             }
//         });
//         return filtered;
//     };
// });


