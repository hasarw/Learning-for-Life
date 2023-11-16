<?php
require_once "/includes/function.php";

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Learning for Life | WorldVision International</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="assets/css/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- <link rel="stylesheet" type="text/css" href="font-awesome/css/font-awesome.min.css" /> -->

</head>

<body>
<div class="container">

<div class="header-img-inside">
<img class="img-logo" src="assets/img/677wvi2.jpg">
</div>

<div class="row">
  <div class="col-md-12">

    <div class="center">
  	<div class="wrapper">

  		<form action="login.php" method="POST" class="form-signin">
  		    <h3 class="form-signin-heading">Sign In</h3>
          <p>Please enter your username and password.</p>

  			  <input type="text" class="form-control" name="Username" placeholder="Username" required="" autofocus="" />
  			  <input type="password" class="form-control" name="Password" placeholder="Password" required=""/>

  			  <button class="btn btn-lg btn-primary btn-block"  name="submit" value="Login" type="Submit">Login</button>

          <?php
          if(isset($_GET['error'])){
            echo "<br/><span class='badge'>The Username or Password is incorrect.</span>";
          }
          ?>

  		</form>

  	</div>
  </div>
<br/><br/>
</div>
</div>
</div>

<?php

//sec_session_start(); // Our custom secure way of starting a PHP session.

if (isset($_POST['submit'])) {

    $email = htmlentities($_POST['Username']);
    $password = htmlentities($_POST['Password']); // The hashed password.

    $hashed_password = sha1($password);

    if (login($email, $hashed_password) == true) {

        header('Location: home.php');
    } else {

        header('Location: login.php?error=1');
    }
}

?>

<div class="container hidden-print" id="footer-area">
<div class="footer navbar-fixed">
<div id="footer">
      <div class="container">
        <p class="text-muted credit">World Vision Afghanistan - <b>Learning for Life Project</b> - 2017</p>

      </div>
    </div>
  </div>
</div>


</html>


<?php //require_once "footer.php"; ?>
