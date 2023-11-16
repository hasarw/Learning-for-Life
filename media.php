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

echo "<div class='row' id='form-platte'>
  <button class='btn btn-sm btn-info' data-toggle='collapse' id='menu-toggle-1' data-target='#newReport'>Media <i class='glyphicon glyphicon glyphicon-menu-down'></i></button>
</div>";
}

?>

<div class="media-form collapse" id="newReport">
<div class="row">
<br/>
  <div class="col-md-5">
  <form name="myForm" action="media.php" method="post" enctype="multipart/form-data">

                <div class="form-group">
                  <label for="title">Album Title:</label>
                  <input type="text" class="form-control" id="title" name="media_title" required />
                </div>

                <div class="form-group">
                  <label for="title">Description:</label>
                  <textarea class="form-control" id="desc" name="media_desc" required></textarea>
                </div>

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
    <h4><b>Photo Albums</b></h4>
    <table class="table">
      <tr ng-repeat="photo in photos | filter: { media_type : 1 }">
      <!-- <td><img src="{{photo.media_add}}" class="img-box"></td> -->
      <td>{{photo.media_title}}</td>
      <td>{{photo.media_desc}}</td>

      <td><a href='media_view.php?album_id={{photo.media_id}}' data-toggle='tooltip' title='View Album'><i class='glyphicon glyphicon-fullscreen'></a></td>

      <?php if ($_SESSION['member_type'] == 1) {
      echo "<td><a href='media_insert.php?album_id={{photo.media_id}}' data-toggle='tooltip' title='Edit Album'><i class='glyphicon glyphicon-pencil'></a></td>
      <td><a href='media.php?remove_album_id={{photo.media_id}}' data-toggle='tooltip' title='Remove Album'><i class='glyphicon glyphicon-erase'></a></td>";
      }

      ?>

      </tr>

    </table>

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
  

  $media_title = $_POST['media_title'];
  $media_desc = $_POST['media_desc'];


// $target_dir = "media/";
// $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
// $uploadOk = 1;
// $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// // Check if image file is a actual image or fake image

//     if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
//         echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
//     } else {
//         echo "Sorry, there was an error uploading your file.";
//     }

  $functions->insertMedia($media_title, $media_desc, 1);

  echo "<script>window.location = 'media.php';</script>";
}


if(isset($_GET['remove_album_id'])){

  $remove_album_id = $_GET['remove_album_id'];

  $functions->deleteVideo($remove_album_id);

  unlink("mediaPhotos.json");


  $functions->getMedia();

  $functions->getPhotos();


  echo "<script>window.location = 'media.php';</script>";

}

?>