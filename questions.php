<?php

require_once "/includes/function.php";
require_once "header.php";
require_once "query_functions.php";

$functions = new query_functions();
$functions -> getQuestions();

?>

<div class="container">
<div ng-app="myModule">
<div ng-controller="ctrlRead">

<div class="row" id="row-searchForm">

    <form class="form-inline" role="search">

        <div class="input-group">
            <input type="text" class="form-control" placeholder="Search in list" name="q" ng-model="search">
            <div class="input-group-btn">

                <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                <input type="number" class="form-control number_class" placeholder="Number of Rows" name="num" ng-model="searchNumber.number">

            </div>
        </div>

    </form><br/>
</div> <!-- end of row SearchForm -->


<div class="row" id="row-showAllTable">
  <div class="table-responsive">
          <table class="table table-striped table-condensed table-hover">
              <thead>

                  <tr>
                      <th ng-click="sort(question_id)">ID
                        <span class="" ng-show="sortKey==beneficiary_id" ng-class=""></span>
                      </th>
                      <th ng-click="sort(question_code)">Code
                        <span class="" style="width: 150px !important" ng-show="sortKey==beneficiary_name" ng-class=""></span>
                      </th>
                      <th class="description" style="width: 1000px" ng-click="sort(question_desc)">Question Description</th>

                  </tr>

              </thead>



              <tbody>
                  <tr dir-paginate="item in items | filter:search | orderBy:sortKey:reverse | itemsPerPage: searchNumber.number">
                      <td>{{item.question_id}}</td>
                      <td>{{item.question_code}}</td>
                      <td>{{item.question_desc }}</td>

                  </tr>

                  <tr ng-repeat-end>
                      <td></td>
                      <td>Total</td>
                      <td>{{ getTotal() }}</td>


                  </tr>



              </tbody>
          </table>
        </div>

          <div class="divCenter">
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

<script type="text/javascript" src="assets/js/angular.min.js"></script>
<script type="text/javascript" src="assets/js/ui-bootstrap-tpls-2.3.1.min.js"></script>
<script type="text/javascript" src="assets/js/dirPagination.js"></script>

<script type="text/javascript">

var fessmodule = angular.module('myModule', ['angularUtils.directives.dirPagination'])

fessmodule.controller('ctrlRead', ['$scope','$filter' ,'$http', function ($scope, $filter, $http) {

    angular.element(document).ready(function(){

        var request2 = $http({
            method: "get",
            url : "questions.json"
        });

        request2.then(function(response){
            $scope.items = response.data;
        });


// $scope.sort = function(keyname){
//   $scope.sortKey = keyname;
//   $scope.reverse = !$scope.reverse;
// };
//
// $scope.showAll = function (){
//   $scope.counter = 1000;
// }
//
//
//

$scope.getTotal = function(){
    var total = 0;
    for(var i = 0; i < $scope.items.length; i++){
        var product = $scope.items[i];
        total += 1;
    }
    return total;
}

});

}]);


</script>

<?php require_once "footer.php"; ?>
