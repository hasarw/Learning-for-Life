<?php

require_once "/includes/function.php";
require_once "db.php";
require_once "query_functions.php";

require_once "header.php";

$functions = new query_functions();

$functions->getSlides();

?>

<div ng-app="app">
  <div ng-controller="mediaCntl">
    <div class="container" ng-init="select()" ng-cloak>

<?php if ($_SESSION['member_type'] == 1) {

echo "<div class='row' id='form-platte'>
<button class='btn btn-sm btn-info' data-toggle='collapse' id='menu-toggle-1' data-target='#newReport'>Slide <i class='glyphicon glyphicon glyphicon-menu-down'></i></button><br/>
</div>";

}

?>

<div class="media-form collapse" id="newReport">
<br/>

<div class="row">
  <div class="col-md-5">
    
    <p>You must upload images with 1134x440 dimintions.</p>

  <form name="myForm" action="slider_photo_upload.php" method="post" enctype="multipart/form-data">

                <div class="form-group">
                  <label for="title">Slide Title:</label>
                  <input type="text" class="form-control" id="title" name="media_title" required />
                </div>

                <div class="form-group">
                  <label for="title">Slide Description:</label>
                  <textarea class="form-control" id="desc" name="media_desc" required></textarea>
                </div>

                <div class="form-group">
                <label class="btn btn-default btn-file">
                  Browse <input type="file" id="upload_file" name="fileToUpload" onchange="preview_image();" hidden/>
                </label>
                </div>

                <div class="form-group">
                  <button class="btn btn-info" name="submit">Add</button>
                </div>
  </form>

  </div>
  
  </div>
</div>



<div class="row">
  <div class="col-md-10">
    <h4>Slides</h4>

    <table class="table">

    <!-- Get the data from database -->

    <?php

    $data = $functions->getSlides();
    foreach ($data as $key => $value) {

      echo "

      <tr>
      <td><img class='img-box-2' src='$value[slide_address]'></td>
      <td>$value[slide_title]</td>
      <td>$value[slide_desc]</td>";

      if ($_SESSION['member_type'] == 1) {

      echo "<td><a class='btn btn-default btn-sm' ng-click='goUp($value[slide_id], $value[slide_num])'>
        <i class='glyphicon glyphicon-arrow-up'></i></a>
      <a class='btn btn-default btn-sm' ng-click='deleteSlide($value[slide_id])'><i class='glyphicon glyphicon-remove'></i></a>
      </td>";

    }
      echo "</tr>";
     
    }

    ?>


    </table>
  </div>
</div>

      </div>
    </div>
  </div>





<?php require_once "footer.php"; ?>

<script type="text/javascript" src="assets/js/slider_js.js"></script>


<script>

$(".td-class").click(function(){

  var idOrgin = ($(this).attr('id'));
  console.log(idOrgin);

});

</script>

