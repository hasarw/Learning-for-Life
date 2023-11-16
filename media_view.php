<?php

require_once "/includes/function.php";
require_once "db.php";
require_once "query_functions.php";

require_once "header.php";

$album_id = $_GET['album_id'];

$functions = new query_functions();

?>

<style>
    .modal-dialog {width:800px;}
.thumbnail {margin-bottom:6px;}

</style>


<div ng-app="app">
  <div ng-controller="mediaCntl">
    <div class="container" ng-init="getPhotoAdds()" ng-cloak>
    
      <div class="container">
  <div class="row">
    <p class="">Photos - Album id: <?php echo $album_id; ?></p>
    <div class="row">

    <div ng-repeat="photo in photosAddress | filter: {photo_media_id:'<?php echo $album_id; ?>'}"">


      <div class="col-lg-3 col-sm-4 col-6"><a class="thumbnail img-responsive" id="image-modal" href="#" title="Image 1" ng-click="showImage(photo.photo_add)"><img src="media\{{photo.photo_add}}" ></a></div>
      

    </div>
      
    </div>
    <!-- <hr>
    <a href="http://bootply.com/71401">Edit on Bootply</a>
    <hr> -->
  </div>
</div>
<div id="myModal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog">
  <div class="modal-content">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">×</button>
    <h3 class="modal-title">{{$scope.img_address}}</h3>
  </div>
  <div class="modal-body">
    <img src="media\{{img_address}}" class="img-responsive">



  </div>

  <div class="modal-footer">
    <button class="btn btn-default" data-dismiss="modal">Close</button>
  </div>
   </div>
  </div>
</div>


    </div>
  </div>
</div>




<?php require_once "footer.php"; ?>

<script>

$('.thumbnail').click(function(){

    $('.modal-body').empty();
    var title = $(this).parent('a').attr("title");
    $('.modal-title').html(title);
    $($(this).parents('div').html()).appendTo('.modal-body');
    // $('#myModal').modal({show});
    $('#myModal').modal('show'); 
});



</script>


<script type="text/javascript">
  
var app = angular.module('app', [])
app.controller('mediaCntl', ['$scope','$filter' ,'$http', function($scope, $filter, $http) {

 $scope.getPhotoAdds=function(){
    var request4 = $http({
        method: "get",
        url : "mediaPhotosAddress.json"
        });

        request4.then(function(response){
            $scope.photosAddress = response.data;
        });
}

$scope.showImage=function(address){

    $scope.img_address = address;

    $('#myModal').modal('show'); 
 

}


}]);

</script>

