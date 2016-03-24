<?php
require '../include/init.php';

if ($_SESSION['user_type'] != 'admin'){
                header("location: login.php");
                exit();
    }
$log = new login_Admin();
if (!$log->get_session()) {
    header('location: login.php');
}
//logout
if(isset($_REQUEST['q']) && $_REQUEST['q'] == 'logout'){
    $log->end_session();
    header("location: login.php");
}

if (!empty($_REQUEST['user_name']) && !empty($_REQUEST['user_password']) && !empty($_REQUEST['user_type'])){
        $user_name = $log->test_input($_REQUEST['user_name']);
        $user_password = $log->test_input($_REQUEST['user_password']);
        $user_type = $log->test_input($_REQUEST['user_type']);
        $log->set_users($user_name, $user_password, $user_type);
        if ($log){
            $success['log'] = 'Making user successed';
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DarFlow - add new user</title>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">
  </head>

  <body>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">DarFlow</a>
    </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
          <li><a href="index.php">Dashboard<span class="sr-only">(current)</span></a></li>
          <li class="active"><a href="users.php">Users</a></li>
          <li><a href="categories.php">Categories</a></li>

          </ul>
        </li>
      </ul>
    <form class="navbar-form navbar-left">
      <input type="text" class="form-control col-lg-8 search-form" placeholder="Search">
    </form>
      <ul class="nav navbar-nav navbar-right">
          <li><a href="index.php?q=logout">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>

    <section>
<div class="container">
<div class="row">
<div class="col-md-4">
<div class="list-group">
    <a href="index.php" class="list-group-item">
    <i class="glyphicon glyphicon-dashboard"></i> Dashboard
  </a>
    <a href="users.php" class="list-group-item active"><i class="glyphicon glyphicon-user"></i> User Acounts</a>
    <a href="categories.php" class="list-group-item"><i class="glyphicon glyphicon-list-alt"></i> Categories</a>

</div>
</div>
<div class="col-md-8">
<div class="row">
<div  class="col-md-12">
<h1 class="page-header"> <i class="glyphicon glyphicon-home"></i> Add New User </h1>
</div>

</div>
<ol class="breadcrumb">
    <li><a href="index.php">Dashoard</a></li>
 <li><a href="clinics.php">Users</a></li>
 <li class="active">Add user</li>
 
</ol>

    <form action="newuser.php" method="post">
  <div class="form-group">
    <label>User Name</label>
    <input type="text" name="user_name" class="form-control" placeholder="Enter the user name">
  </div>
    
    <div class="form-group">
    <label>Password</label>
    <input type="password" name="user_password" class="form-control" placeholder="Enter password">
  </div>
    <div class="form-group">
    <label>Group</label>
    <select class="form-control" name="user_type">
    	<option value="Admin">Admin</option>
        <option value="Inserter">Inserter</option>
        <option value="Viewer">Viewer</option>
    </select>
  </div>

  <button type="submit" class="btn btn-default">Add</button>
</form>
    <h4 class="text-center"><?php echo (isset($success['log']))?$success['log']:''; ?></h4>


</div>
</div>
</div>
    </section>

<footer>
<p>Copyright 2015, All Rights Reserved</p>
</footer>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/main.js"></script>
    <script src="js/jquery.tablesorter.js"></script>
    <script>
	    $(function(){
      $('#sort-table').tablesorter({
        sortList:[[0,0], [1,0]]
      });
    });
	</script>
   <script>
      var $rows = $('table tr');
      $('.search-form').keyup(function() {
        var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();
        $rows.show().filter(function() {
          var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
          return !~text.indexOf(val);
        }).hide();
      });
    </script>
  </body>
</html>
