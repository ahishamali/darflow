
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>OCS - add new clinic</title>
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
      <a class="navbar-brand" href="#">Darflow</a>
    </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
          <li><a href="index.php">Dashboard<span class="sr-only">(current)</span></a></li>
        <li class="active"><a href="clinics.php">Clinics</a></li>
        <li><a href="users.php">Users</a></li>
        <li><a href="categories.php">Categories</a></li>

          </ul>
        </li>
      </ul>
    <form class="navbar-form navbar-left">
      <input type="text" class="form-control col-lg-8 search-form" placeholder="Search">
    </form>
      <ul class="nav navbar-nav navbar-right">
          <li><a href="login.php">Logout</a></li>
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
  <a href="clinics.php" class="list-group-item active"><i class="glyphicon glyphicon-home"></i> Clinics</a>
  <a href="users.php" class="list-group-item"><i class="glyphicon glyphicon-user"></i> User Acounts</a>
  <a href="categories.php" class="list-group-item"><i class="glyphicon glyphicon-list-alt"></i> Categories</a>

</div>
</div>
<div class="col-md-8">
<div class="row">
<div  class="col-md-12">
<h1 class="page-header"> <i class="glyphicon glyphicon-home"></i> Add New Clinic </h1>
</div>

</div>
<ol class="breadcrumb">
    <li><a href="index.php">Dashoard</a></li>
 <li><a href="clinics.php">Clinics</a></li>
 <li class="active">Add clinic</li>
 
</ol>

    <form action="">
  <div class="form-group">
    <label>Clinic Name</label>
    <input type="text" class="form-control" placeholder="Enter a clinic name">
  </div>
    <div class="form-group">
    <label>Category</label>
    <select class="form-control">
    	<option value="1">Cat one</option>
        <option value="2">Cat two</option>
        <option value="3">Cat three</option>
    </select>
  </div>
    <div class="form-group">
    <label>Doctor Name</label>
    <input type="text" class="form-control" placeholder="Enter the doctor's Name">
  </div>
  
 
  
  <button type="submit" class="btn btn-default">Add</button>
</form>


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
