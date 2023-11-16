<?php

require_once "db.php";
include_once "header.php";
require_once "query_functions.php";

$functions = new query_functions();

$functions -> getBenf();

?>


<div ng-app="myModule">
<div ng-controller="ctrlRead">
<div class="container" ng-cloak>
<div class="row hidden-print" id="row-searchForm">

    <form class="form-inline" role="search">

      <div class="form-group has-feedback" id="filterBox">
          <input type="text" class="form-control" placeholder="Search in list" name="q" ng-model="search">
          <i class="glyphicon glyphicon-search form-control-feedback"></i>

          <!-- <div class="input-group-btn">
              <button class="btn btn-default" type="submit"></button>
          </div> -->

      </div>

      <div class="form-group">
          <input type="number" class="form-control rowNumber" placeholder="# Rows" name="num" ng-model="searchNumber.number">
      </div>

        <label>District:</label>
          <select ng-model="filterDistrict" ng-options="items.district_name as items.district_name group by item.district_name for items in items | unique:'district_name'" class="form-control" style="height: 40px">
        </select>

        <label>Village:</label>
          <select ng-model="myselect" ng-options="items.village_name as items.village_name group by item.district_name for items in items | unique:'village_name'" class="form-control" style="height: 40px">
        </select>

        <label>Gender:</label>
          <select ng-model="filterSex" ng-options="items.benf_gender as items.benf_gender group by item.benf_gender for items in items | unique:'benf_gender'" class="form-control" style="height: 40px">
        </select>

        <label><a href="" class="btn btn-info" onclick="location.reload();">Reset filters</a></label>

    </form><br/>
</div> <!-- end of row SearchForm -->

<div class="row">

  <div class="details hidden-print">
  <p>Number of Beneficiaries: <span class='badge'>{{ rowCountTotal(filterDistrict) }}</span> |
  Total Male: <span class='badge'>{{ rowCountGenderMale(filterDistrict) }}</span> |
  Total Female: <span class='badge'>{{ rowCountGenderFemale(filterDistrict) }}</span> |

  Total Male in Village {{myselect}}: <span class='badge'>{{ rowCountGenderMaleVillage(myselect) }}</span> |
  Total Female in Village {{myselect}}: <span class='badge'>{{ rowCountGenderFemaleVillage(myselect) }}</span> | </p>
  </div>

</div>

  <div class="row hidden-print" >
    <div class="section-textarea" style="padding-bottom: 20px">

    <button class="btn btn-info btn-print hidden-print" ng-click="printFunction()">Print</button>
    <button class="btn btn-info btn-print hidden-print" data-toggle="collapse" data-target="#CommentHide">Add Comments</button>

    <div class="btn-show">
    <button class="btn btn-info btn-print hidden-print" data-toggle="collapse" data-target="#tableHide">See All</button>
    </div>

    <div class="text-area collapse" id="CommentHide">
        <br/>
      <div class="form-group">
    <input type="text" class="form-control" placeholder="Title" ng-model="item.print_title"></textarea>
      </div>

      <div class="form-group">
    <textarea class="form-control" name="text-section" rows="5" id="comment1" placeholder="Description" ng-model="item.print_desc"></textarea>
      </div>

      <!-- <div class="form-group">
    <button class="btn btn-info btn-print hidden-print" ng-click="">Lock</button>
      </div> -->

    </div>
  </div>
</div>

<div class="row">
  <div class="section-textarea" style="padding-bottom: 20px">

    <h1 ng-bind="item.print_title" class="text-center"></h1>
    <p ng-bind="item.print_desc"></p>


</div>
</div>



<div class="row" id="row-showAllTable">

  <div class="table-responsive collapse" id="tableHide">
    <br/>
          <table class="table tableScroll table-striped table-condensed table-hover">
              <thead>
                  <tr class="table-title">
                      <th ng-click="sort(benf_code)">Code
                        <span class="glyphicon glyphicon-sort" ng-show="sortKey==beneficiary_id" ng-class=""></span>
                      </th>
                      <th ng-click="sort(benf_survey_code)">Survey Code
                        <span class="glyphicon glyphicon-sort" ng-show="sortKey==beneficiary_name" ng-class=""></span>
                      </th>
                      <th class="field5" ng-click="sort(benf_gender)">Name</th>
                      <th class="description" ng-click="sort(district_name)">District</th>
                      <th class="field3" ng-click="sort(village_name)">Village</th>
                      <th class="field4" ng-click="sort(benf_age)">Age</th>
                      <th class="field5" ng-click="sort(benf_gender)">Gender</th>
                      <th class="field8">Status</th>
                  </tr>
              </thead>

              <tbody>
                  <tr dir-paginate="item in items | filter:filterSex | filter:filterDistrict | filter:myselect | filter:filterType | filter:search | orderBy:sortKey:reverse | itemsPerPage: searchNumber.number">
                      <td>{{item.benf_code}}</td>
                      <td>{{item.benf_survey_code}}</td>
                      <td>{{item.benf_name}}</td>
                      <td>{{item.district_name}}</td>
                      <td>{{item.village_name}}</td>
                      <td>{{item.benf_age}}</td>
                      <td>{{getGender(item.benf_gender)}}</td>
                      <td>{{getStatus(item.benf_status)}}</td>
                  </tr>

                  <tr ng-repeat-end>
                  </tr>

              </tbody>
          </table>
</div>

          <div class="divCenter hidden-print">
          <dir-Pagination-controls
          max-size = "10"
          direction-links="true"
          boundary-links="true">
          </dir-pagination-controls>
          </div>
</div> <!-- end of show all table -->


      </div>
    </div>
</div>
</div>

<?php require_once "footer.php"; ?>


<script type="text/javascript" src="assets/js/ui-bootstrap-tpls-2.3.1.min.js"></script>
<script type="text/javascript" src="assets/js/angular-filter.min.js"></script>


<script type="text/javascript">

var fessmodule = angular.module('myModule', ['angularUtils.directives.dirPagination','angular.filter'])

.filter("gender", function(){
  return function (beneficiary_gender){
    switch (beneficiary_gender){
      case "Male":
      return "Male";

      case "Female":
      return "Female";

      case "nothing":
      return "3";
    }
  }
});

fessmodule.controller('ctrlRead', ['$scope','$filter','$http', function ($scope, $filter, $http) {

    angular.element(document).ready(function(){

        var request2 = $http({
            method: "get",
            url : "benf.json"
        });

        request2.then(function(response){
            $scope.items = response.data;
        });
});

angular.element(document).ready(function () {


$scope.sort = function(keyname){
  $scope.sortKey = keyname;
  $scope.reverse = !$scope.reverse;
};


$scope.getStatus = function(benf_status){
  var status = benf_status;
  if(status == 1){
    return 'Active';
  }else{
    return 'DeActive';
  }
};


$scope.getGender = function(benf_gender){
  var status = benf_gender;
  if(status == 'M'){
    return 'Male';
  }else{
    return 'Female';
  }
};

$scope.printFunction = function(){

  $(".table").removeClass("tableScroll");
  print();
  $(".table").addClass("tableScroll");

}

$scope.rowCountTotal = function(district){
  var filtered = $scope.items.filter(item => (item.district_name == district));
  return filtered.length;
};


$scope.rowCountGenderMale = function(district){
  var filtered = $scope.items.filter(item => (item.benf_gender === "M") && (item.district_name == district));
  return filtered.length;
};


$scope.rowCountGenderFemale = function(district){
  var filtered = $scope.items.filter(item => (item.benf_gender === "F") && (item.district_name == district));
  return filtered.length;
};

$scope.rowCountGenderFemaleVillage = function(district){
  var filtered = $scope.items.filter(item => (item.benf_gender === "F") && (item.village_name == district));
  return filtered.length;
};


$scope.rowCountGenderMaleVillage = function(district){
  var filtered = $scope.items.filter(item => (item.benf_gender === "M") && (item.village_name == district));
  return filtered.length;
};

// $scope.showAll = function (){
//   $scope.counter = 1000;
// }
//
// $scope.getTotal = function(){
//     var total = 0;
//     for(var i = 0; i < $scope.items.length; i++){
//         var product = $scope.items[i];
//         total += 1;
//     }
//     return total;
// }


});
}]);


</script>



<?php require_once "footer.php"; ?>
