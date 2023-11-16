<?php

require_once "/includes/function.php";
require_once "header.php";
require_once "query_functions.php";

$functions = new query_functions();

?>

<div class="container" ng-app="myModule">

<div class="row">
<div class="col-md-8">

  <h4 class="text-primary">Account Details</h4><br/>
<p>Login Name: <b><?php echo $_SESSION['member_username']; ?></b></p>
<p>Member Name: <?php echo $_SESSION['member_name']; ?></p>
<?php if($_SESSION['member_type'] == 1){
  $type = "Administrator";
}else{
  $type = "Viewer";
}
?>
<p>Account Type: <?php echo $type; ?></p>
</p>
</div>
</div>

<br/>
<p>You can change your password by filling the below form.
Password should have more than 8 characters. </p><br/>

<div class="row" ng-controller="ctrlRead">
<div class="col-md-6">

<form class="form" method="post" action="profile.php" name="changePasswordForm">

    <div class="form-group">
        <input type="password" class="form-control" placeholder="Current Password" name="passwordOld" ng-blur="search()" ng-model="keywords">
        <span class="inline">  {{ data['data'] }}</p>
    </div>

    <div class="form-group">
        <input type="password" class="form-control" placeholder="New Password" name="passwordNew" ng-blur="checkPasswordLength()" ng-model="form.newPassword">
        <span class="inline">  {{ checkPasswordText }}</p>
    </div>

    <div class="form-group">
        <input type="password" class="form-control" placeholder="Repeat New Passowrd" name="passwordRepeat" ng-blur="checkPassword()" ng-model="form.rePassword">
    </div>
    <p class="inline">{{ checkPasswordMatch }}</p>

    <div class="form-group">
        <input type="submit" class="btn btn-info btn-sm disabled" value="Save Changes" name="chnagePassword">
    </div>

    {{$scope.result}}
    <?php
    if(isset($_GET['passwordChnage'])){
    echo "<p class='inline'>Password Succesfully changed.</p>";
    }
    ?>

</form>


</div> <!-- end of col-->
</div> <!-- end of row -->
</div> <!-- end of container-->

<?php require_once "footer.php"; ?>
<?php
//Get password from the database and then decrypt it. after that compare it with what the user typed
//in current password field.
if(isset($_POST['chnagePassword'])){

  $passwordOld = $_POST['passwordOld'];
  $passwordOld = sha1($passwordOld);

  $password = $functions -> GetPassword($_SESSION['member_id']);
  $password = sha1($password);

  if($password == $passwordOld){

  $passwordNew = $_POST['passwordNew'];
  $passwordRepeat = $_POST['passwordRepeat'];

  if($passwordNew == $passwordRepeat){
    if($functions -> SetPassword($passwordNew, $_SESSION['member_id']));
    echo "<script>window.location = 'profile.php?passwordChnage=1';</script>";
  }
}
}
?>

<script type="text/javascript">

var app = angular.module('myModule', []);
app.controller('ctrlRead', function ($scope, $http) {

  	$scope.url = 'search.php'; // The url of our search

  	// The function that will be executed on button click (ng-click="search()")
  	$scope.search = function() {

  		// Create the http post request
  		// the data holds the keywords
  		// The request is a JSON request.

      $http.post($scope.url, { "data" : $scope.keywords, "id" : '<?php echo $_SESSION['member_id']; ?>'}).then(function(data, status) {
			$scope.status = status;
			$scope.data = data;
			$scope.result = data; // Show result from server in our <pre></pre> element
  		}).catch(function(data, status) {
  			$scope.data = data || "Request failed";
  			$scope.status = status;
  		});
  	};

    $scope.checkPasswordLength = function() {

        var password = $scope.form.newPassword;

        if(password.length >= 8){
          $scope.checkPasswordText = 'More than 8 Character, Accepted.';

        }else{
          $scope.checkPasswordText = 'Less than 8 Character, Not Accepted.';
        }
    };

    $scope.checkPassword = function() {
      var newPassword = $scope.form.newPassword;
      var reNewPassword = $scope.form.rePassword;

        if( newPassword === reNewPassword ){
          $scope.checkPasswordMatch = 'Passwords Matches.';
          $('.disabled').removeClass('disabled');
        }else{
          $scope.checkPasswordMatch = 'Passwords does not Matches.';
        }
    };
});
</script>
