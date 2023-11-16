<?php require_once "/includes/function.php"; ?>
<?php check_login(); ?>
<?php date_default_timezone_set("Asia/kabul"); ?>
<?php $date_time = date("Y-m-d h:i:s"); ?>
<!DOCTYPE html>

<html>
<head>

    <meta charset="utf-8" />

    <title>Learning for Life | WorldVision International</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="assets/css/bootstrap/bootstrap.min.css">

    <!-- <link rel="stylesheet" href="assets/css/bootstrap-editable/bootstrap-editable.css"> -->
    <link rel="stylesheet" href="assets/css/bootstrap-editable/xeditable.css">
    <link rel="stylesheet" href="assets/css/jquery-ui/jquery-ui.css">

    <link rel="stylesheet" href="assets/css/color-picker/bootstrap-colorpicker.css">
    <link rel="stylesheet" href="assets/css/style.css">

    <link rel="stylesheet" href="assets/css/p/popeye.css">    

    <!-- .<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->
    <!-- <link rel="stylesheet" type="text/css" href="font-awesome/css/font-awesome.min.css" /> -->

    <!-- For Test Graphs-->
    <!-- Any Chart CDN: <script src="https://cdn.anychart.com/js/7.12.0/anychart-bundle.min.js"></script> -->

    <script src="assets/js/anychart-bundle.min.js"></script>

    <link rel="stylesheet" href="assets/css/anychart-ui.min.css" />
    <link rel="stylesheet" href="assets/css/select.css" />
    <!-- The Age Slider -->
    <link rel="stylesheet" type="text/css" href="assets/slider/rzslider.min.css">

    <!-- The DatePicker -->
    <!-- <link rel="stylesheet" type="text/css" href="assets/js/datepicker/bootstrap-datepicker.min.css"> -->
    <link rel="stylesheet" type="text/css" href="assets/js/datepicker/bootstrap-datetimepicker.css">



    <link rel="stylesheet" href="assets/css/timeline/timeline.min.css">

    



</head>

<?php

$url = $_SERVER['REQUEST_URI'];
$activeClass = "";

if ($url == "/lfl/Home.php"){
  $activeIndex = "active";
}
if ($url == "/lfl/tracker.php"){
  $activeTracker = "active";
}
if ($url == "/lfl/location.php"){
  $activeLocation = "active";
}
if ($url == "/lfl/beneficiaries.php"){
  $activeBeneficiaries = "active";
}
if ($url == "/lfl/report.php"){
  $activeReport = "active";
}
if ($url == "/lfl/questions.php"){
  $activeQuestions = "active";
  $activeBaseline = "active";
}
if ($url == "/lfl/survey.php"){
  $activesurvey = "active";
  $activeBaseline = "active";
}
if ($url == "/lfl/analysis.php"){
  $activeAnalysis = "active";
  $activeBaseline = "active";
}
if ($url == "/lfl/profile.php"){
  $activeProfile = "active";
}
if ($url == "/lfl/project_update.php"){
  $activeUpdate = "active";
  $activeIndex = "active";
}
if ($url == "/lfl/task.php"){
  $activeTask = "active";
}
if ($url == "/lfl/glossary.php"){
  $activeGlossary = "active";
}
if ($url == "/lfl/media.php"){
  $activeMedia = "active";
}
if ($url == "/lfl/video.php"){
  $activeVideo = "active";
}
if ($url == "/lfl/slider.php"){
  $activeSlider = "active";
}
if ($url == "/lfl/analysis_all.php"){
  $activeAnalysis_all = "active";
}


?>
<body>

<!-- Search Navbar - START -->
<nav class="navbar navbar-default navbar-fixed-top container" role="navigation">
  <div class="header-img">

    <div class="header-img-user mantra"><img src = "assets/img/mantra.png" style="width: 500px; padding-top: 10px">
    </div>

  <div class="header-img-user hidden-print hidden">
  <h4><span class="label label-warning">Login as: <?php echo $_SESSION['member_name']; ?></b>
  <a href="profile.php" class="text-muted">Profile Settings</a>
  </span></h4>
  </div>
  <!-- write query string for this one-->


  </div>


  <div class="header-img-inside vissible-print" style="background-color: white !important">
  <img class="img-logo" src="assets/img/677wvi2.jpg">
  </div>

  </div>
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="home.php"><span class="glyphicon glyphicon-home"></span>  Learning for Life</a>
    </div>
    <div class="collapse navbar-collapse lfl-menu" id="bs-example-navbar-collapse-1">

        <ul class="nav navbar-nav"> <!-- List of all menu -->

            <li class="dropdown home <?php echo $activeIndex; ?>"><a class="dropdown-toggle" href="/lfl/Home.php" data-toggle="dropdown">Home<span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
                <!-- <li class="survey <?php //echo $activeIndex; ?>"><a href="/lfl/Home.php">Home Page</a></li> -->
                <li class="survey <?php echo $activeUpdate; ?>"><a href="/lfl/project_update.php">Project Updates</a></li>

                <li class="survey <?php echo $activeProfile; ?>"><a href="/lfl/profile.php">User Managment</a></li>

                <li class="survey <?php echo $activeHome; ?>"><a data-toggle='modal' data-target='#show_about_lfl'>About LFL</a></li>
            </ul>
            </li>

            <li class="dropdown tracker <?php echo $activeTracker; ?>"><a class="dropdown-toggle" data-toggle="dropdown">Tracker<span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
             <!--    <li class="survey <?php echo $activeTracker; ?>"><a href="/lfl/tracker.php">Project Tracker</a></li>
                <li class="survey <?php echo $activeTask; ?>"><a href="/lfl/task.php">Task</a></li> -->

                <li class="survey <?php echo $activeTask; ?>"><a href="/lfl/activity_new.php">Tracker</a></li>

                
            </ul>
            </li>

            <li class="location <?php echo $activeLocation; ?>"><a href="/lfl/location.php">Location</a></li>
            <li class="beneficiaries <?php echo $activeBeneficiaries; ?>"><a href="/lfl/beneficiaries.php">Beneficiary</a></li>

            <li class="dropdown <?php echo $activeBaseline; ?>"><a class="dropdown-toggle" href="#" data-toggle="dropdown">Project Baseline<span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
                <li class="survey <?php echo $activesurvey; ?>"><a href="/lfl/survey.php">Baseline Survey</a></li>
                <li class="questions <?php echo $activeQuestions; ?>"><a href="/lfl/questions.php">Questions</a></li>
                <li class="analysis <?php echo $activeAnalysis; ?>"><a href="/lfl/analysis.php">Analysis</a></li>
                  <li class="analysis_all <?php echo $activeAnalysis_all; ?>"><a href="/lfl/analysis_all.php">Analysis All Questions</a></li>
            </ul>
            </li>

            

            <li class="dropdown <?php echo $activeMedia; ?>"><a class="dropdown-toggle" href="#" data-toggle="dropdown">Media<span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
                <li class="report <?php echo $activeMedia; ?>"><a href="/lfl/media.php">Photos</a></li>
                <li class="video <?php echo $activeVideo; ?>"><a href="/lfl/video.php">Videos</a></li>
                <li class="sliderPage <?php echo $activeSlider; ?>"><a href="/lfl/slider.php">Slider</a></li>
            </ul>
            </li>


            <li class="report <?php echo $activeReport; ?>"><a href="/lfl/report.php">Report</a></li>
            <li class="report <?php echo $activeGlossary; ?>"><a href="/lfl/glossary.php">Glossary</a></li>

            <li class="logout <?php echo $activelogout; ?>"><a href="/lfl/includes/logout.php">Log Out</a></li>

        </ul>
        <!-- <div class="col-sm-2 col-md-2 pull-right">
            <form class="navbar-form" role="search">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search" name="q" ng-model="search">
                    <div class="input-group-btn">
                        <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                    </div>
                </div>
            </form>
        </div> -->

    </div>
</nav>



<!-- Modal - Update User details -->
<div class="modal fade" id="show_about_lfl" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">About Application</h4>
            </div>
            <div class="modal-body">

         <div class="table-responsive section-pie-chart" style="background-color: #e6ccff; padding: 10px; border-radius: 20px;">

        <table class="table table-condensed section-table-details">

          <tr><b>Overview:</b></tr>

          <tr>
            LFL database Application is an online multiuser application which written in all open source and free technologies. This application enhance the management, tracking and data analysis for WorldVision Learning for Life project.
          </tr>

          <tr>
            <p><br/><br/><b>Technologies:</b><br/>
            PHP 5.6<br/>
            Apache Server<br/>
            Twitter Bootstrap Framework<br/>
            Bootstrap libraries (bootstrap color picker, bootstrap date picker)<br/>
            jQuery 3.2.1<br/>
            jQuery UI <br/>
            Google AngularJs<br/>
            AngularJS libraries (angular-filter, xeditable, Angular chart, Angualr sanitize)<br/>
            All of these Technologies are Free and Open Source. All under<a href="https://opensource.org/licenses/MIT"> MIT</a> licance.<br/></p>
      
          </tr>

        </table>

        </div>
      </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
            </div>
        </div>
    </div>
</div>
<!-- // Modal -->


<div class="startMargin" style="margin-top: 150px">
<!-- Search Navbar - END -->
