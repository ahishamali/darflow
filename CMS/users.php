<?php
require '../include/init.php';

if ($_SESSION['user_type'] != 'admin') {
    header("location: ../login.php");
    exit();
}

$log = new login_Admin();
if (!$log->get_session()) {
    header('location: ../login.php');
}

//logout
if (isset($_REQUEST['q']) && $_REQUEST['q'] == 'logout') {
    $log->end_session();
    header("location: ../login.php");
}

if (isset($_REQUEST['delete']) && !empty($_REQUEST['delete'])) {
    $log->delete_user($_REQUEST['delete']);
}

$user = $log->get_users();
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Darflow - Users Accounts</title>
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
                    <a class="navbar-brand" href="index.php">DarFlow</a>
                </div>

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li><a href="index.php">Dashboard<span class="sr-only">(current)</span></a></li>

                        <li class="active"><a href="users.php">Users</a></li>
                        <li><a href="categories.php">Categories</a></li>

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

                            <a href="users.php" class="list-group-item active"><i class="glyphicon glyphicon-user"></i> User Accounts</a>
                            <a href="categories.php" class="list-group-item"><i class="glyphicon glyphicon-list-alt"></i> Categories</a>

                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <div  class="col-md-6">
                                <h1 class="page-header"><i class="glyphicon glyphicon-user"></i> Accounts</h1>
                            </div>
                            <div  class="col-md-6">



                                <div class="btn-group actions" role="group" aria-label="...">
                                    <a href="newuser.php" class="btn btn-default"><i class="glyphicon glyphicon-plus"></i>New</a>
                                </div>
                            </div>
                        </div>
                        <ol class="breadcrumb">
                            <li><a href="index.php">Dashoard</a></li>
                            <li><a href="categories.php"> Categories</a></li>
                            <li class="active">Useres Account</li>
                        </ol>

                        <table class="table table-striped">
                            <tr>
                                <th>ID</th>
                                <th>User Name</th>
                                <th>Password</th>
                                <th>Group</th>
                                <th>Status</th>
                                <th>Delete</th>
                            </tr>

                            <?php foreach ($user as $row) { ?>
                                <tr>
                                    <td class="user_id"><?php echo $row['user_id']; ?></td>
                                    <td class="user_name"><?php echo $row['user_name']; ?></td>
                                    <td class="user_password"><?php echo $row['user_password']; ?></td>
                                    <td class="user_type"><?php echo $row['user_type']; ?></td>
                                    <td class="user_status"><?php echo ($row['user_status'] == '1') ? '<i class="glyphicon glyphicon-check"></i>' : '<i class="glyphicon glyphicon-remove"></i>'; ?></td>
                                    <td><a href="users.php?delete=<?php echo $row['user_id']; ?>" style="color: red;"><i class="glyphicon glyphicon-remove"></i></a></td>
                                </tr>
                            <?php } ?>

                        </table>
                        <nav>
                            <ul class="pagination">
                                <li>
                                    <a href="#" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <li><a href="#">1</a></li>
                                <li><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                                <li><a href="#">4</a></li>
                                <li><a href="#">5</a></li>
                                <li>
                                    <a href="#" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </section>

        <footer>
            <p>Copyright 2016, All Rights Reserved</p>
        </footer>
        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="js/bootstrap.js"></script>
        <script src="js/main.js"></script>
        <script src="js/jquery.tablesorter.js"></script>
        <script>
            $(function () {
                $('#sort-table').tablesorter({
                    sortList: [[0, 0], [1, 0]]
                });
            });
        </script>
        <script>
            var $rows = $('table tr');
            var type, id;
            $('.search-form').keyup(function () {
                var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();
                $rows.show().filter(function () {
                    var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
                    return !~text.indexOf(val);
                }).hide();
            });
            //start
            $('td').dblclick(function () {
                var value = $(this).text();
                type = $(this).attr('class');
                id = $(this).parent().children('.user_id').text();
                if ($(this).text() === '') {
                    if ($(this).children('i').attr('class') === 'glyphicon glyphicon-check') {
                        $(this).html('<input type="checkbox" value="0" checked>');
                    } else {
                        $(this).html('<input type="checkbox" value="1">');
                    }
                } else {
                    $(this).html('<input type="text" value="' + value + '">');
                }
            });

            $('body').click(function () {
                $('td input').change(function () {
                    $.get('../ajax/change_user_details.php', {type: type, value: $(this).val(), id: id}, function (data) {
                        if (data === 'success') {
                            location.reload();
                        }
                    });
                });
            });

        </script>
    </body>
</html>
