<?php

require_once "/includes/function.php";
require_once "db.php";
require_once "query_functions.php";
require_once "header.php";

$functions = new query_functions();

?>

<div ng-app="app">
  <div ng-controller="PieCtrl">
    <div class="container" ng-cloak>
  <div class="row" id="home-section-1">

    <div class="col-md-8">
      <div class="google_map_section" id="map"></div>
    </div>

    <div class="col-md-4 project_update_section">
    <p class="span-color-p"><a class="span-color-p-link" href='project_update.php'><b>Project Updates </a><span class="glyphicon glyphicon-pushpin" style="float: right; font-size: 20px"></b></p>
    <div class="table-responsive tableScroll">

      <table class="table table table-condensed">
        <?php
        $id = 0;
        $icon = "";
        date_default_timezone_set("Asia/kabul");
        foreach ($functions -> getUpdates() as $x) {

          if(date_diff($date,$x['update_date'])){
            $icon = "<span class='glyphicon glyphicon-star span-color'></span>";
          }
          echo "<tr><td class='td-class' id='td-$id'><p>".$icon." ".$x['update_title']."  <br/><span class='small-font'>".$x['update_date']." by: ".$x['member_name']."</span><span style='font-size:12px !important'><a href='#' data-toggle='modal' data-target='#show_data'>Read More...</a></span></p></td></tr>";
          echo "<p class='hidden p-class' id='ttd-$id'>".$x['update_title']."</p>";
          echo "<p class='hidden p-class' id='ptd-$id'>".$x['update_desc']."</p>";
          $id++;
          $icon = "";
        }
        ?>
      </table>

    </div>
    </div>
  </div> <!-- end of the map row -->

<hr>

  <div class="row" id="home-section-2">

    <div class="col-md-6">
      <div class="img-responsive center">
        <img src="assets/img/mission-icon.png" class="imgSize">
      </div>

      <h2>Mission Statement:</h2>
      <p>Our mission is to provide cost-effective, life-saving, life-improving
         and non-formal education for isolated, insecure, deprived and hard-to-reach communities
         through mobile phones.</p>
    </div>

    <div class="col-md-6">
      <div class="img-responsive center">
        <img src="assets/img/vision-icon.png" class="imgSize">
      </div>

      <h2>Vision Statement:</h2>
      <p>Our vision is make non-formal education fun,
      cost-effective and accessible through mobile phones.</p>
    </div>

  </div>
<hr>

<div class="row" id="section-slider">

  <div class="col-md-10" style="text-align: center;">
<!-- Here is the slider -->
<div id="myCarousel" class="carousel slide" data-ride="carousel" style="width: 120%; text-align: center !important;">
  <!-- Indicators -->

  <!-- what I need here? go through the database and select all photos -->

  <?php
  echo "<ol class='carousel-indicators'>";
  foreach ($functions->getSlides() as $key => $value) {
    $counter = 0;
    if($counter == 0){
      $class = "active";
    }
   echo "<li data-target='#myCarousel' data-slide-to='$counter' class='$class'></li>";
   $counter++;

  }
  echo "</ol>";

  ?>

  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox" style="height: 440px !important">
  
  <?php

  $counter_slide = 0;
  foreach ($functions->getSlides() as $key => $value) {
    # code...
    $slide_address = $value['slide_address'];
    $slide_title = $value['slide_title'];
    $slide_desc = $value['slide_desc'];
    $slide_date = $value['slide_date'];

    $class_slide = "";

    if($counter_slide == 0){
      $class_slide = "active";
    }

    echo "<div class='item $class_slide'>
    <img src='$slide_address' class='img-big' alt='$slide_title'>
    <div class='carousel-caption'>
        <h3 style='background-color:#2bb92e'>$slide_title</h3>
        <p style='background-color:rgba(43, 43, 43, 0.3)'>$slide_desc</p>
    </div>
    </div>";
  $counter_slide++;
  }

  ?>

  </div>
  <!-- Left and right controls -->
  <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>

  <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>

</div>

</div>
</div>





<!-- Modal - About LFL project -->
<div class="modal fade" id="show_data" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"></h4>
            </div>
            <div class="modal-body">

                <p class="desc_data"></p>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
            </div>
        </div>
    </div>
</div>
<!-- // Modal -->
<div class="container">

  <div class="row" id="home-section-3">

    <div class="col-md-12">

    <div class="col-md-6">
    <div class="section-pie-chart" style="background-color: white; padding: 10px">

      <p class="bigger">Number of Beneficiaries<span class="smaller"><a href="beneficiaries.php" style="float: right">Details</a></span></p>

      <canvas width="300px" height="150px" id="pie" class="chart chart-pie"
        chart-colors="colors" chart-data="data" chart-labels="labels" chart-options="options" >
      </canvas>

    </div>

  <div class="table-responsive section-pie-chart" style="background-color: #e6ccff; padding: 10px; border-radius: 20px;">

    <table class="table table-condensed">
      <tr><td><b>Target Areas</b></td><td>Province, District and Village</td></tr>
      <tr><td><b>Province</b></td><td>2 (Herat and Badghis)</td></tr>
      <tr><td><b>Districts</b></td><td>5</td></tr>
      <tr><td><b>Villages</b></td><td>40</td></tr>
      <tr><td><b>Number of Beneficiaries</b></td><td>720</td></tr>
      <tr><td><b>Types of Study Groups</b></td><td>2 in Herat and Badghis</td></tr>
      <tr><td><b>Mobile Group</b></td><td>2 (1 in Herat, 1 in Badghis</td></tr>
      <tr><td><b>No of beneficiaries</b></td><td>360</td></tr>
      <tr><td><b>Manual Group (Book-based)</b></td><td>2 (1 in Herat, 1 in Badghis)</td></tr>
      <tr><td><b>No of beneficiaries</b></td><td>360</td></tr>
    </table>

  </div>

  </div>

      <div class="col-md-6">
        <p class="bigger">Project Overview<span class="glyphicon glyphicon-edit" style="float: right; font-size: 20px"></span></p>
         <div class="table-responsive section-pie-chart" style="background-color: #e6ccff; padding: 10px; border-radius: 20px;">
        <table class="table table-condensed section-table-details">
          <tr ng-repeat="abc in datas">
            <td style="width: 200px"><b>{{ abc.Title }}</b></td>
            <td>{{ abc.Description }}</td>
          </tr>
        </table>
        </div>
      </div>
</div>
<!-- Another Col -->

<!-- THE END OF THE PAGE! -->

    </div>
</div>


<?php require_once "footer.php"; ?>

<?php

$gozarah = $functions -> countBeneficiary("beneficiary_district","'Gozarah'");
$enjil = $functions -> countBeneficiary("beneficiary_district","'Enjil'");
$karookh = $functions -> countBeneficiary("beneficiary_district","'Karookh'");
$moqor = $functions -> countBeneficiary("beneficiary_district","'Moqor'");
$qala = $functions -> countBeneficiary("beneficiary_district","'Qala-e-Now'");

$a = 'Hello';
echo "<h1>".$$a;


?>


<script>

var app = angular.module("app", ['chart.js']);
app.controller('PieCtrl', function($scope, $http){


  $http.get('details.json')
     .then(function(res){
        $scope.datas = res.data;
      });

  $scope.labels = ["Gozarah", "Enjil", "Karookh", "Moqor", "Qala-e-Now"];
  $scope.colors = ["#ff9900", "#ff0000", "#008000", "#0080ff", "#bf00ff"];
  $scope.data = [<?php echo $gozarah; ?>, <?php echo $enjil; ?>, <?php echo $karookh; ?>, <?php echo $moqor; ?>, <?php echo $qala; ?>];
  $scope.options = {legend: {display: true, position: 'bottom'}};

});

</script>



<script>
function initMap() {

        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 8,
          center: {lat: 34.8, lng: 63}
        });

        // Create an array of alphabetical characters used to label the markers.
        var labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        var labels = ['Gozarah - <?php echo $gozarah; ?>','Karookh - <?php echo $karookh; ?>','Injil - <?php echo $enjil; ?>','Qala-e-Now - <?php echo $moqor; ?>','Moqor - <?php echo $qala; ?>'];

        // Add some markers to the map.
        // Note: The code uses the JavaScript Array.prototype.map() method to
        // create an array of markers based on a given "locations" array.
        // The map() method here has nothing to do with the Google Maps API.
        var markers = locations.map(function(location, i) {
          return new google.maps.Marker({
            position: location,
            label: labels[i % labels.length]
          });
        });

        // Add a marker clusterer to manage the markers.
        var markerCluster = new MarkerClusterer(map, markers,
            {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});
      }

      var locations = [
        {lat: 34.2015534, lng: 62.2011995},
        {lat: 34.4886904, lng: 62.5855706},
        {lat: 34.4923021, lng: 61.9058626},
        {lat: 34.982031, lng: 63.0942243},
        {lat: 35.2208789, lng: 62.7544713}
      ]

</script>

<script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAooWHPnwpRGGjbODhqFA0LXN-8aHRap3M&callback=initMap">

</script>


<script>
$(".td-class").click(function(){

   var idOrgin = ($(this).attr('id'));

   var id = '#p'+idOrgin;
   var str = $(id).text();

   var title = '#t'+idOrgin;
   var titleText = $(title).text();

   $('.desc_data').html(str);

   $('.modal-title').html(titleText);

});
</script>


<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});



$('.carousel').carousel()
</script>