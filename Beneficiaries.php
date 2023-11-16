<?php
require_once "db.php";
include_once "header.php";
require_once "query_functions.php";

$functions = new query_functions();

?>

<?php

$sql = "SELECT tbl_beneficiary.`beneficiary_id`, tbl_beneficiary.`beneficiary_code`, tbl_beneficiary.`beneficiary_name`, tbl_beneficiary.`beneficiary_gender`, tbl_beneficiary.`beneficiary_district`, tbl_beneficiary.`beneficiary_village`, tbl_beneficiary.`beneficiary_province`, tbl_beneficiary.`beneficiary_type`, tbl_beneficiary.`beneficiary_age`, tbl_beneficiary.`beneficiary_relation_name`, tbl_beneficiary.`beneficiary_relation`, tbl_beneficiary.`beneficiary_phone_number`, tbl_telecom.`telecom_number`, tbl_beneficiary.`beneficiary_status` FROM `tbl_beneficiary`,tbl_telecom WHERE tbl_beneficiary.`beneficiary_phone_provider` = tbl_telecom.`telecom_id`";

$result = $conn->query($sql);

if ($result->num_rows > 0) {

        $rows = array();
        while($r = mysqli_fetch_assoc($result)) {
            $rows[] = $r;
        }

        $fp = fopen('person.json', 'w');
        fwrite($fp, json_encode($rows, JSON_UNESCAPED_UNICODE ));
        fclose($fp);

        $conn->close();

      }
?>


<div ng-app="myModule">
<div ng-controller="ctrlRead">
<div class="container" ng-cloak>
<div class="row hidden-print" id="row-searchForm">

   
        <!-- <div class="form-group">
            <input type="number" class="form-control rowNumber" placeholder="# Rows" name="num" ng-model="searchNumber.number">
        </div>

        <br/><br/>

        <label>Province:</label>
          <select ng-model="filterProvince" ng-options="items.beneficiary_province as items.beneficiary_province group by item.beneficiary_province for items in items | unique:'beneficiary_province'" class="form-control" style="height: 40px">
          <option value="">Select</option>
         </select>

        <label>District:</label>
          <select ng-model="filterDistrict" ng-options="items.beneficiary_district as items.beneficiary_district group by item.beneficiary_district for items in items | filter:filterProvince | unique:'beneficiary_district'" class="form-control" style="height: 40px">
          <option value="">Select</option>
         </select>

        <label>Village:</label>
          <select ng-model="myselect" ng-options="items.beneficiary_village as items.beneficiary_village group by item.beneficiary_village for items in items | filter:filterDistrict | filter:filterProvince | unique:'beneficiary_village'" class="form-control" style="height: 40px">
          <option value="">Select</option>
        </select>

        <label>Gender:</label>
          <select ng-model="filterSex" ng-options="items.beneficiary_gender as (items.beneficiary_gender | genderFilter) for items in items | unique:'beneficiary_gender'" class="form-control" style="height: 40px">
          <option value="">Select</option>
        </select>

        <label>Type:</label>
          <select ng-model="filterType" ng-options="items.beneficiary_type as items.beneficiary_type for items in items | unique:'beneficiary_type'" class="form-control" style="height: 40px">
          <option value="">Select</option>
        </select></form> -->

</div> <!-- end of row SearchForm -->

<br/>
<div class="row hidden-print">
  <div class="col-md-4">

    <label>Filter by Province</label>
    <ui-select multiple ng-model="selected.province" theme="bootstrap" ng-change="getDistrictList()">
    <ui-select-match placeholder="Province...">{{$item}}</ui-select-match>
    <ui-select-choices repeat="beneficiary_province in province">
      <div ng-bind="beneficiary_province | highlight: $select.search"></div>
    </ui-select-choices>
    </ui-select>

    <label>Filter by District</label>
    <ui-select multiple ng-model="selected.district" theme="bootstrap" ng-change="getVillageList(); getProvinceByDistrict();">
    <ui-select-match placeholder="District...">{{$item}}</ui-select-match>
    <ui-select-choices repeat="beneficiary_district in district">
      <div ng-bind="beneficiary_district | highlight: $select.search"></div>
    </ui-select-choices>
    </ui-select>

  </div>
  <div class="col-md-4">

    <label>Filter by Village</label>
    <ui-select multiple ng-model="selected.village" theme="bootstrap" ng-change="getDistrictByVillage()">
    <ui-select-match placeholder="Village...">{{$item}}</ui-select-match>
    <ui-select-choices repeat="beneficiary_village in village">
      <div ng-bind="beneficiary_village | highlight: $select.search"></div>
    </ui-select-choices>
    </ui-select>

    <label>Filter by Phone</label>
    <ui-select multiple ng-model="selected.items" theme="bootstrap">
    <ui-select-match placeholder="Phone...">{{$item}}</ui-select-match>
    <ui-select-choices repeat="beneficiary_name in types">
      <div ng-bind="beneficiary_name | highlight: $select.search"></div>
    </ui-select-choices>
    </ui-select>

</div>
<div class="col-md-4">

    <label>Filter by Gender</label>
    <ui-select multiple ng-model="selected.gender" theme="bootstrap">
    <ui-select-match placeholder="Gender...">{{$item}}</ui-select-match>
    <ui-select-choices repeat="g in gender">
      <div ng-bind="g | highlight: $select.search | genderFilter"></div>
    </ui-select-choices>
    </ui-select>

    <label>Filter by Type</label>
    <ui-select multiple ng-model="selected.type" theme="bootstrap">
    <ui-select-match placeholder="Study Type...">{{$item}}</ui-select-match>
    <ui-select-choices repeat="beneficiary_type in type">
      <div ng-bind="beneficiary_type | highlight: $select.search"></div>
    </ui-select-choices>
    </ui-select>

  </div>
</div>

<br/>
<div class="row">

<div class="col-md-1">

  <h4 style="margin-top: 25px">Filter by Age:</h4>

</div>

<div class="col-md-11">
  
  <rzslider rz-slider-model="slider.minValue"
          rz-slider-high="slider.maxValue"
          rz-slider-options="slider.options"> 
  </rzslider>


</div>




</div>


<div class="row hidden-print" style="margin: 20px">

  <a href="" class="danger" ng-click="resetForm()">Reset Filters</a>

</div>

<div class="row">
  <div class="details hidden-print">
  <p>Number of Beneficiaries: <span class='badge'>{{ rowCountTotal(selected.province) }}</span> |
    District: <span class='badge'>{{rowCountDistrict(selected.district)}}</span> |
    Village: <span class='badge'>{{rowCountVillage(selected.village)}}</span> |
  Total Male in District: <span class='badge'>{{ rowCountGenderMaleDistrict(selected.district) }}</span> |
  Total Female in District: <span class='badge'>{{ rowCountGenderFemaleDistrict(selected.district) }}</span> |
  Total Male in Village: <span class='badge'>{{ rowCountGenderMaleVillage(selected.village) }}</span> |
  Total Female in Village: <span class='badge'>{{ rowCountGenderFemaleVillage(selected.village) }}</span> | 
  Total Age Range: <span class='badge'>{{ counterTable(slider.minValue, slider.maxValue)}}</span>
  </p>
  </div>
</div>



<div class="row hidden-print" >
  <div class="section-textarea" style="padding-bottom: 20px">

  <button class="btn btn-info btn-print hidden-print" ng-click="printFunction()">Print</button>
  <button class="btn btn-info btn-print hidden-print" data-toggle="collapse" data-target="#CommentHide">Add Comments</button>
  <button class="btn btn-info" id="showPrint">Print Options</button>



<!--   <div class="btn-show">
  <button class="btn btn-info btn-print hidden-print" data-toggle="collapse" data-target="#tableHide">See All</button>
  </div>
 -->

  <div class="text-area collapse" id="CommentHide">
      <br/>
    <div class="form-group">
  <input type="text" class="form-control" placeholder="Title" ng-model="item.print_title">
    </div>

    <div class="form-group">
  <textarea class="form-control" name="text-section" rows="5" id="comment1" placeholder="Description" ng-model="item.print_desc"></textarea>
    </div>

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

        <!-- <div class="table-responsive"> -->

          <!-- <div class="table-responsive collapse" id="tableHide"> -->

          <div class="table-responsive" id="tableHide">

          <form class="form-inline search-form" role="search">
          <div class="form-group has-feedback" id="filterBox">
              <input type="text" class="form-control" placeholder="Search in list" name="q" ng-model="search">
              <i class="glyphicon glyphicon-search form-control-feedback"></i>
              <br/>
          </div>
          </form>
          <div class="table-responsive" id = "table2excel">
          <table class="table table-fixed table-striped table-condensed tableScroll table-hover" name="table">

              <thead>
                  <tr class="table-title">
                      <th ng-click="sort(beneficiary_code)">Code</th>
                      <th>Name</th>
                      <th>Gender</th>
                      <th class="">Age</th>
                      <th class="field3" ng-click="sort(beneficiary_district)">District</th>
                      <th class="field4" ng-click="sort(beneficiary_province)">Province</th>
                      <th class="field5" ng-click="sort(beneficiary_village)">Village</th>
                      <th class="field6" ng-click="sort(beneficiary_type)">Study Type</th>
                      <th class="field7" ng-click="sort(beneficiary_phone)">Phone</th>
                      <th class="field8" ng-click="sort(telecom_number)">Phone Provider</th>
                  </tr>
              </thead>

              <tbody>
                  <tr dir-paginate="item in items | filter:customFilterProvince | filter:customFilterDistrict | filter:customFilterVillage | filter:customFilter | filter:customFilterGender | filter:customFilterType | filter:search | filter:byRange(slider.minValue, slider.maxValue) | orderBy:sortKey:reverse | itemsPerPage: searchNumber.number">
                      <td>{{item.beneficiary_code}}</td>
                      <td>{{item.beneficiary_name}}</td>
                      <td>{{item.beneficiary_gender | genderFilter}}</td>
                      <td>{{item.beneficiary_age}}</td>
                      <td>{{item.beneficiary_district}}</td>
                      <td>{{item.beneficiary_province}}</td>
                      <td>{{item.beneficiary_village}}</td>
                      <td>{{item.beneficiary_Type}}</td>
                      <td>{{item.beneficiary_phone_number}}</td>
                      <td>{{item.telecom_number}}</td>
                  </tr>

                  <!-- <tr ng-repeat-end>
                      <td></td>
                      <td></td>
                      <td>{{ getTotal() }}</td>
                      <td></td>
                      <td>A</td>
                      <td></td>
                  </tr> -->

              </tbody>
          </table>
        </div>
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




<?php require_once "footer.php"; ?>

<script type="text/javascript" src="assets/js/js_benf.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">
$( document ).ready(function() {



$( "#showPrint" ).click(
  function() {

    var tables = $("table").tableExport();

    // $("table").tableExport.remove();

     $("#showPrint").hide(200);
 
  }
);


 });

   



</script>





