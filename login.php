<?php

require_once 'include/init.php';

$error = array();

$login = new login();
if (isset($_REQUEST['user_name'],$_REQUEST['user_password']) && !empty($_REQUEST['user_name']) && !empty($_REQUEST['user_password'])){
    extract($_REQUEST);
    $success = $login->login_f($user_name, $user_password);
    if ($success){
        header("location: index.php");
        exit();
    }else{
//        error login
        $error['login'] = "<div class='alert alert-dismissible alert-danger'>
    <h4 class='text-center'><strong>invalid user name or password !!</strong></h4>
</div>";
    }
}

if ($login->get_session()){
    header("location: index.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DarFlow - login</title>
    <!-- Bootstrap core CSS -->
    <link href="lib/css/bootstrap.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="lib/css/style.css" rel="stylesheet">
    <script src="lib/js/jquery.min.js"></script>
  </head>

  <body id="login">
<div class="container">

      <form class="form-signin" action="login.php" method="post">
        
          <img src="lib/img/logo.png" height="200" width="300" class="form-signin-heading text-center"><label for="inputEmail" class="sr-only">User Name</label>
        <input id="inputEmail" class="form-control" name="user_name" placeholder="Email address" required autofocus type="text">
        <label for="inputPassword" class="sr-only">Password</label>
        <input kl_virtual_keyboard_secure_input="on" id="inputPassword" name="user_password" class="form-control" placeholder="Password" required type="password">
        <br>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      </form>
    <?php echo isset($error['login'])?$error['login']:""; ?>
    </div>
      



    

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/bootstrap.js"></script>
    <script src="js/main.js"></script>
  </body>
</html>
