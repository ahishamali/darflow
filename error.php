<?php
//start
require_once 'include/init.php';

$login = new login();
$conn = new connection();

if (!$login->get_session()) {
    header('location: login.php');
    exit();
}
if (isset($_REQUEST['logout'])) {
    $login->end_session();
    header("location: login.php");
}

if (isset($_REQUEST['search']) && !empty($_REQUEST['search'])) {
    $search = $_REQUEST['search'];
    if (isset($_REQUEST['advance'])) {
        $
        $conn->conn->query("select * from inboxes where doc_title like '%$search%'");
    } else {
        
    }
}
//end
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Page not found</title>
        <!-- Bootstrap core CSS -->
        <link rel="stylesheet" href="lib/css/bootstrap.min.css">
        <script src="lib/js/jquery.min.js"></script>
        <script src="lib/js/bootstrap.min.js"></script>
        <link href="lib/css/bootstrap.css" rel="stylesheet">
        <link href="lib/css/font-awesome.css" rel="stylesheet">
        <!-- Custom styles for this template -->
        <link href="lib/css/style.css" rel="stylesheet">
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
                    <a class="navbar-brand" href="index.php">DarFlow</a>
                </div>

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

                    <form action="<?php
                    echo htmlspecialchars($_SERVER['PHP_SELF']);
                    echo (isset($_REQUEST['search'])) ? "?advance" : "";
                    ?>" class="navbar-form navbar-left" role="search">
                        <div class="form-group">
                            <input class="form-control" name="search" placeholder="Search" type="text">
                        </div>
                        <input type="hidden" name="cat_id">
                        <input type="hidden" name="sort">
                        <button type="submit" class="btn btn-default" title="Search"><i class="glyphicon glyphicon-search"></i></button>

                    </form>
                    <ul class="nav navbar-nav">
                        <li><a href="<?php
                            echo htmlspecialchars($_SERVER['PHP_SELF']);
                            echo (isset($_REQUEST['advance'])) ? "" : "?advance";
                            ?>" title="Advance Search"><i class="glyphicon glyphicon-cog"></i></a></li>
                    </ul>

                    <ul class="nav navbar-nav navbar-right">
                        <?php if ($_SESSION['user_type'] === 'admin') { ?><li><a href="CMS/">Admin Panel</a></li><?php } ?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">UserName <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#change_pass" data-toggle="modal">Change Password</a></li>
                                <li class="divider"></li>
                                <li><a href="#">Logout</a></li>

                            </ul></li>
                    </ul>
                </div>
            </div>
            <!--advance search tools-->
            <div id="adv_search" style="background: black;display: none;">
                <form>
                    <select id="cat_id">
                        <option disabled selected></option>
                    </select>
                    <select id="sort">
                        <option selected value="asc">Asc</option>
                        <option value="desc">Desc</option>
                    </select>
                </form>
            </div>
            <!--end-->
        </nav>


        <section>
            <div class="container">
                <div class="row">


                    <div class="col-md-12">
                        <div id="error" class="jumbotron">

                            <h1><strong>ERROR 404..</strong></h1>
                            <h1><strong>PAGE NOT FOUND</strong></h1>
                            <br><br><br>
                            <p><a href="index.php" class="btn btn-primary btn-lg">Back to Home</a></p>
                        </div>
                    </div>
                </div>
            </div>
            <footer>
                <p>Copyright 2015, All Rights Reserved SAR</p>
            </footer>
            <!-- Bootstrap core JavaScript
            ================================================== -->
            <!-- Placed at the end of the document so the pages load faster -->




            <script>
                var $rows = $('table tr');
                $('.search-form').keyup(function () {
                    var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();
                    $rows.show().filter(function () {
                        var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
                        return !~text.indexOf(val);
                    }).hide();
                });

                //            start
<?php if (isset($_REQUEST['advance'])) { ?>
                    $('#adv_search').show();
<?php } else { ?>
                    $('#adv_search').hide();
<?php } ?>
                $('input[name=hidden]').val($('#cat_id').val());
                //                end
            </script>
    </body>
</html>
