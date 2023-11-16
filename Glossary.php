<?php

require_once "/includes/function.php";
require_once "/includes/config.php";
require_once "header.php";

require_once "query_functions.php";
$functions = new query_functions();

session_start();

?>

<div class="container" ng-app="myApp" ng-cloak>
<div class="" ng-controller="myCtrl">

<div class="row hidden-print">
<div class="col-md-4">

<?php

if ($_SESSION['member_type'] == 1) {
  echo "<a href='#' class='btn btn-sm btn-info' data-toggle='modal' data-target='#show_data_form'>Add a Term</a>";
}

$functions->selectGlossary();

?>

</div>

</div>

  <div class="row">
  <div class="table-responsive" id="showReport">

      <table class='table table-bordered'>
        <tr>
        
        <td colspan="3" class="text-center">Learning for Life Glossary <a href="#" class="btn btn-sm btn-info" style="float: right;" onclick="window.print()">Print/PDF</a></td>          

        </tr>
      <tr class='header-black'>
      <th class="td-center hidden-print" style="width: 300px">
            
            <form class="navbar-form" role="search">
                      <div class="input-group">
                          <input type="text" class="form-control" placeholder="Acronym" name="q" ng-model="search" style="background-color: #f1f1f1">
                          <div class="input-group-btn">
                              <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                          </div>
                      </div>
             </form>
</th>
<th class="hidden visible-print-block">Acronym</th>
      <th class="td-center">Definition</th>

      <?php

      if($_SESSION['member_type'] == 1){
        echo "<th class='td-center hidden-print' style='width: 70px'>Edit</th>";
      }

      ?>

    </tr>

    <tr ng-repeat="x in items | filter:search">
      
      <td id="key-{{x['glossary_id']}}">{{x['glossary_key']}}</td>
      <td id="def-{{x['glossary_id']}}">{{x['glossary_def']}}</td>


<?php if ($_SESSION['member_type'] == 1) {

      echo "<td class='hidden-print'>
      <a ng-click='edit_glossary(x.glossary_id, x.glossary_key, x.glossary_def)' id={{x['glossary_id']}} href='' data-toggle='modal' data-target='#show_data'><i class='glyphicon glyphicon-edit'></i></a>

      <a href='glossary.php?key_id={{x['glossary_id']}}' onclick='return checkDelete()'><i class='glyphicon glyphicon-trash'></i></a>
      </td>";
    }
?>
    </tr>

    </div>
  </div>
</div>
</div>
</div>

<!-- Modal - Update User details -->
<div class="modal fade" id="show_data" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title modal-title-title">Edit Report</h4>
                <h4 id='martikeh'></h4>
            </div>
            <div class="modal-body">
                <form class="form" method="post" action="glossary.php" >
                <input type="text" class="form-control id_data hidden" name="id_text"
                value="{{glossary_id_text}}">

                <div class="form-group">
                  <label for="title">Acronym:</label>
                  <input type="text" class="form-control title_data" name="abb_text_edit" value="{{glossary_key_text}}" required />
                </div>

                <div class="form-group">
                  <label for="desc">Definition:</label>
                  <textarea class="form-control desc_data" name="def_text_edit" required />{{glossary_def_text}}</textarea>
                </div>
                <button type="submit" class="btn btn-default" name="submitEdit">Save</button>
              </form>
            </div>
        </div>
    </div>
</div>
<!-- // Modal -->


<!-- Modal - Update User details -->
<div class="modal fade" id="show_data_form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title modal-title-title">Add Acronym</h4>
          </div>
            <div class="modal-body">

              <form name="myForm" action="glossary.php" method="post">

                <div class="form-group">
                  <label for="title">Acronym:</label>
                  <input type="text" class="form-control" id="title" name="abbreviation" ng-model="abbreviation" required />
                </div>

                <div class="form-group">
                  <label for="title">Definition:</label>
                  <input type="text" class="form-control" id="desc" name="defination" ng-model="defination" required />
                </div>

                <div class="form-group">
                  <button class="btn btn-info" name="submit">Submit</button>
                </div>
              </form>
            </div>
        </div>
    </div>
</div>
<!-- // Modal -->



<?php require_once "footer.php"; ?>

<script type="text/javascript">

var app = angular.module("myApp", []); 
app.controller('myCtrl', ['$scope', '$http', function ($scope, $http) {

    angular.element(document).ready(function(){

        var request2 = $http({
            method: "get",
            url : "json/glossary.json"
        });

        request2.then(function(response){
            $scope.items = response.data;
        });
});

      $scope.edit_glossary = function(id, key, def) { 

      $scope.glossary_id_text = id;
      $scope.glossary_key_text = key;
      $scope.glossary_def_text = def;

    };

}]);

</script>


<!-- <script>

   $( document ).ready(function() {

   $(".td-class").click(function(){

    alert('asdasdas');

   var idOrgin = ($(this).attr('id'));

   var title_id = '#key-'+idOrgin;
   var desc_id = '#def-'+idOrgin;

   var title = $(title_id).text();
   var desc = $(desc_id).text();

   $('.id_data').val(idOrgin);
   $('.title_data').val(title);
   $('.desc_data').val(desc);

});

});
</script> -->

<script type="text/javascript">
// We can write our own fileUpload service to reuse it in the controller

$('#menu-toggle-1').click(function(){
    $(this).find('i').toggleClass('glyphicon glyphicon-menu-up').toggleClass('glyphicon glyphicon-menu-down');
});

$('#menu-toggle-2').click(function(){
    $(this).find('i').toggleClass('glyphicon glyphicon-menu-up').toggleClass('glyphicon glyphicon-menu-down');
});


</script>



<script language="JavaScript" type="text/javascript">
function checkDelete(){
    return confirm('Are you sure?');
}
</script>

<?php

if(isset($_POST['submit'])){

  $abbreviation = $_POST['abbreviation'];
  $defination = $_POST['defination'];

  $conn = new mysqli(HOST, USER, PASSWORD, DATABASE);

  $sql = "INSERT INTO `tbl_glossary`(`glossary_id`, `glossary_key`, `glossary_def`, `glossary_status`) VALUES (null, '$abbreviation', '$defination', 1)";

  if ($conn->query($sql) === TRUE) {
      echo "<script>window.location = 'glossary.php';</script>";
  } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
  }

  $conn->close();

}

if(isset($_POST['submitEdit'])){

  $id_edit = $_POST['id_text'];
  $abb_edit = $_POST['abb_text_edit'];
  $def_edit = $_POST['def_text_edit'];

  if($abb_edit != "" AND $def_edit != "" ){

  $conn = new mysqli(HOST, USER, PASSWORD, DATABASE);

  $sql = "UPDATE `tbl_glossary` SET `glossary_key`= '$abb_edit', `glossary_def`= '$def_edit' WHERE `glossary_id` = $id_edit";

  if ($conn->query($sql) === TRUE) {
      echo "<script>window.location = 'glossary.php';</script>";
  } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
  }

  $conn->close();
  }

}

  if(isset($_GET['key_id'])){

    $id = $_GET['key_id'];

    if($functions -> deleteGlossary($id)){
    echo "<script>window.location = 'glossary.php';</script>";
    };
}

?>
