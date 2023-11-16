<?php

require_once "/includes/function.php";
require_once "db.php";
require_once "query_functions.php";

require_once "header.php";

$functions = new query_functions();

$functions->getMedia();

$functions->getPhotos();

?>

<div ng-app="app">
  <div ng-controller="mediaCntl">
    <div class="container" ng-init="select()" ng-cloak>

    <?php if ($_SESSION['member_type'] == 1) {
echo "
<div class='row' id='form-platte'>
  <button class='btn btn-sm btn-info' data-toggle='collapse' id='menu-toggle-1' data-target='#newReport'>Video Clip <i class='glyphicon glyphicon glyphicon-menu-down'></i></button>
</div>";
}

?>


<div class="media-form collapse" id="newReport">

<br/>

<div class="row">
  <div class="col-md-5">
    
  <form name="myForm" action="video.php" method="post" enctype="multipart/form-data">

                <div class="form-group">
                  <label for="title">Video Title:</label>
                  <input type="text" class="form-control" id="title" name="video_title" required />
                </div>

                <div class="form-group">
                  <label for="title">Video Description:</label>
                  <textarea class="form-control" id="desc" name="video_desc" required /></textarea> 
                </div>

                <label class="btn btn-default btn-file" style="margin-bottom: 20px">
                  Browse <input type="file" id="upload_file" name="fileToUpload" accept="video/*" onchange="preview_image();" multiple hidden/>
                </label>

                <div class="form-group">
                  <button class="btn btn-info" name="submit">Add</button>
                </div>

  </form>

</div>
</div>
</div>

<hr>

<div class="row">

  <div class="col-md-8">
    <h4><b>Video Details</b></h4>
    <h2>{{$scope.filename}}</h2>

    <table class="table">
      <tr ng-repeat="photo in photos | filter: { media_type: 2 }">
      <!-- <td><img src="{{photo.media_add}}" class="img-box"></td> -->
      <td>{{photo.media_title}}</td>
      <td>{{photo.media_desc}}</td>
      <td><a href='#' ng-click="myFunc(photo.media_add)">View</a></td>

<?php if ($_SESSION['member_type'] == 1) {

      echo "<td><a href='video.php?video_id={{photo.media_id}}&video_name={{photo.media_add}}'>Remove</a></td>";

} ?>
      </tr>

    </table>
  </div>


<div id="myModal" class="modal fade modal-wide" tabindex="-1" role="dialog">
  <div class="modal-dialog">
  <div class="modal-content">

  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">×</button>
    <h3 class="modal-title">Preview</h3>
  </div>

  <div class="modal-body">

 <video width="100%" height="auto" controls="controls" type="video/mp4" name="Video Name" src="media/video/{{img_address | trustUrl}}">
   
 </video>

  </div>

  <div class="modal-footer">
    <button class="btn btn-default" data-dismiss="modal" onclick="">Close</button>
  </div>

  </div>
  </div>
</div>

      </div>
    </div>
  </div>
</div>



<?php require_once "footer.php"; ?>

<script type="text/javascript" src="assets/js/media_js.js"></script>


<script>
$(".td-class").click(function(){

  var idOrgin = ($(this).attr('id'));
  console.log(idOrgin);


});
</script>

<?php

if (isset($_POST['submit'])) {
  

  $media_title = $_POST['video_title'];
  $media_desc = $_POST['video_desc'];
  $media_filename = "";

  $target_dir = "media/video/";
  $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
  $uploadOk = 1;
  $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
  // Check if image file is a actual image or fake image

    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";

        $media_filename = basename($_FILES["fileToUpload"]["name"]);

    } else {
        echo "Sorry, there was an error uploading your file.";
    }

  $functions->insertMedia($media_title, $media_desc, 2, $media_filename);

  echo "<script>window.location = 'video.php';</script>";
}


if(isset($_GET['video_id'])){

  $video_id = $_GET['video_id'];
  $video_name = $_GET['video_name'];

  $functions->deleteVideo($video_id);
  unlink('media/video/'."$video_name");

  header("Location: video.php");
  echo "<script>window.location = 'video.php';</script>";

}



?>

