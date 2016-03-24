<?php
require_once '../include/init.php';
$login_error = '';
$log = new login_Admin();


if (isset($_REQUEST['login'])) {
    if (isset($_REQUEST['user_name'], $_REQUEST['user_password']) && !empty($_REQUEST['user_name']) && !empty($_REQUEST['user_password'])) {

        extract($_REQUEST);
        $success = $log->login_A($user_name, $user_password);
        if ($success) {
            if ($_SESSION['user_type'] == 'admin'){
                header("location: index.php");
                exit();
            }elseif ($_SESSION['user_type'] == 'inserter') {

              header("location: error.php ");
              $log->end_session();
                exit();
            }elseif ($_SESSION['user_type'] == 'viewer') {
                header("location: error.php ");
                $log->end_session();
               
                exit();
            }
        } else {
            //error login
            $login_error = 'Wrong username or password';
        }
    }
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
    <link href="css/bootstrap.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">
  </head>

  <body id="login">
<div class="container">

    <form class="form-signin" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        
        <h2 class="form-signin-heading text-center">DarFlow - Dashboard</h2><label for="inputEmail" class="sr-only">Email address</label>
        <input id="inputEmail" class="form-control" placeholder="User Name" name="user_name" required autofocus type="text">
        <label for="inputPassword" class="sr-only">Password</label>
        <input kl_virtual_keyboard_secure_input="on" id="inputPassword" class="form-control" name="user_password" placeholder="Password" required type="password">
        <div class="checkbox">

        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit" name="login" value="login">Sign in</button>
        <h3><?php echo $login_error; ?></h3>
      </form>

    </div>
    

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/main.js"></script>
  </body>
</html>
