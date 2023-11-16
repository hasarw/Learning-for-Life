<?php

require_once "/includes/function.php";
require_once "db.php";
require_once "query_functions.php";

require_once "header.php";

$album_id = $_GET['album_id'];

$functions = new query_functions();

// $functions->getMedia(1);
// $functions->getMedia(2);


// $functions->getPhotos();

?>

<div ng-app="app">
  <div ng-controller="mediaCntl">
    <div class="container" ng-init="getPhotoAdds()" ng-cloak>
    <div class="row">
    	<div class="col-md-12">
    		
    	

    <table class="table" ng-init="getPhotoAdds()">
    	
    <tr ng-repeat="photo in photosAddress | filter: {photo_media_id:'<?php echo $album_id; ?>'}" style="display: inline-block; border-collapse:collapse;">
    	<td><img src="media\{{photo.photo_add}}" class="img-box-2"><br/>
    	<a href="#" ng-click="delePhoto(photo.photo_id,photo.photo_add)" style="position: absolute;"><i class="glyphicon glyphicon-remove" style="top: -20px; right: -2px; color: #ff0000;"></i></a>
    	</td>	
    </tr>

   

    </table>


<div id="wrapper">
 <form action="upload_image.php" method="post" enctype="multipart/form-data">
 <input type="number" name="album_id" class="hidden" value="<?php echo $album_id; ?>">

<label class="btn btn-default btn-file">
    Browse <input type="file" id="upload_file" name="upload_file[]" onchange="preview_image();" multiple hidden/>
</label>

  
  <input type="submit" class="btn btn-info" name='submit_image' value="Upload"/>
 </form>
 <div id="image_preview"></div>
</div>




</div>

    </div>

      </div>
    </div>
  </div>




<?php require_once "footer.php"; ?>

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


 $scope.delePhoto=function(photo_id,photo_name){

 	$http({
      method: "POST", 
      url: "media_delete.php",  
      data: {
	   id: photo_id,
	   filename: photo_name
      }
      }).then(function(response) {
           console.log(response); //get the echo value from php page

      }).catch(function(response) {
            console.log(response);
      });


      location.reload();

}






}]);

</script>

<script>

$(document).ready(function() 
{ 
 $('form').ajaxForm(function() 
 {
  // alert("Uploaded SuccessFully");
  location.reload();
 }); 
});

function preview_image() 
{
 var total_file=document.getElementById("upload_file").files.length;
 for(var i=0;i<total_file;i++)
 {
  $('#image_preview').append("<img class='img-box' style='margin:10px' src='"+URL.createObjectURL(event.target.files[i])+"'>");
 }
}


</script>
