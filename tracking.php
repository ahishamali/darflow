<?php
//start
require_once 'include/init.php';

$login = new login();
$conn = new connection();
$cat = new cat();
$inbox = new inbox();
$outbox = new outbox();
$track = new track();

if (!$login->get_session()) {
    header('location: login.php');
    exit();
}
if (isset($_REQUEST['logout'])) {
    $login->end_session();
    header("location: login.php");
    exit();
}
$result1 = '';
$result2 = '';
if (isset($_REQUEST['search']) && !empty($_REQUEST['search'])) {
    $search = $_REQUEST['search'];
    if (isset($_REQUEST['advance'])) {
        $sort = $_REQUEST['sort'];
        $cat_id = " and cat_id = '" . $_REQUEST['cat_id'] . "'";
        $result1 = $conn->conn->query("select * from inboxes where doc_title like '%$search%'$cat_id order by create_on $sort");
        $result2 = $conn->conn->query("select * from outboxes where doc_title like '%$search%'$cat_id order by create_on $sort");
    } else {
        $result1 = $conn->conn->query("select * from inboxes where doc_title like '%$search%'");
        $result2 = $conn->conn->query("select * from outboxes where doc_title like '%$search%'");
    }
}
//end
if (isset($_REQUEST['type']) && $_REQUEST['type'] === 'inbox') {
    $doc_id = $_REQUEST['doc_id'];
    (isset($_REQUEST['conform_sent'])) ? $conform_sent = $_REQUEST['conform_sent'] : $conform_sent = 0;
    (isset($_REQUEST['conform_received'])) ? $conform_received = $_REQUEST['conform_received'] : $conform_received = 0;
    (isset($_REQUEST['conform_replied'])) ? $conform_replied = $_REQUEST['conform_replied'] : $conform_replied = 0;
    (isset($_REQUEST['conform_replied_received'])) ? $conform_replied_received = $_REQUEST['conform_replied_received'] : $conform_replied_received = 0;
    $track->submit_checkbox_inbox($doc_id, $conform_sent, $conform_received, $conform_replied, $conform_replied_received);
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>DarFlow - Tracking</title>
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

                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="navbar-form navbar-left" role="search">
                        <div class="form-group">
                            <input class="form-control" name="search" placeholder="Search" type="text">
                        </div>
                        <!--start-->
                        <?php if (isset($_REQUEST['advance'])) { ?>
                            <input type="hidden" name="advance">
                            <input type="hidden" name="cat_id">
                            <input type="hidden" name="sort">
                        <?php } ?>
                        <!--end-->
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
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo $_SESSION['user_name']; ?> <span class="caret"></span></a>
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
                <div class="col-lg-2" style="margin-left: 96px;">
                    <select id="cat_id" class="form-control">
                        <option disabled selected>-- Select Category --</option>
                        <?php foreach ($cat->get_cat() as $row) { ?>
                            <option value="<?php echo $row['cat_id']; ?>"><?php echo $row['cat_title']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-lg-2">
                    <select id="sort" class="form-control">
                        <option disabled selected>-- Select sort option --</option>
                        <option value="asc">Asc</option>
                        <option value="desc">Desc</option>
                    </select>
                </div>
            </div>
            <!--end-->
        </nav>
        <!--start-->
        <?php if (isset($_REQUEST['search']) && !empty($_REQUEST['search'])) { ?>
            <?php require_once 'search.php'; ?>
        <?php } else { ?>
            <!--end-->


            <section>
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <h1 class="page-header"> <i class="fa fa-location-arrow"></i> Tracking </h1>
                            <h3>Inbox Table</h3>
                            <table class="table table-striped">
                                <tr>
                                    <th>Doc ID</th>
                                    <th>Doc Title</th>
                                    <th>Date</th>
                                    <th>Sender</th>
                                    <th>Sent</th>
                                    <th>Received</th>
                                    <th>Replied</th>
                                    <th>Reply Received</th>
                                    <th>Submit</th>
                                </tr>
                                <?php foreach ($track->track_inbox() as $row) { ?>
                                    <tr>
                                    <form action="tracking.php" method="post" >
                                        <td> <?php echo $row['doc_id']; ?></td>
                                        <td> <?php echo $row['doc_title']; ?></td>
                                        <td> <?php echo $row['create_on']; ?></td>
                                        <td> <?php echo $row['sender']; ?></td>
                                        <td><input type="checkbox" name="conform_sent" value="1" <?php echo ($row['conform_sent'] == 1) ? "checked" : ""; ?>></td>
                                        <td><input type="checkbox" name="conform_received" value="1" <?php echo ($row['conform_received'] == 1) ? "checked" : ""; ?>></td>
                                        <td><input type="checkbox" name="conform_replied" value="1" <?php echo ($row['conform_replied'] == 1) ? "checked" : ""; ?>></td>
                                        <td><input type="checkbox" name="conform_replied_received" value="1" <?php echo ($row['conform_replied_received'] == 1) ? "checked" : ""; ?>></td>
                                        <input type="hidden" name="doc_id" value="<?php echo $row['doc_id']; ?>">
                                        <td><input type="submit" value="Submit" name="submit"></td>
                                        <input type="hidden" value="inbox" name="type">
                                    </form>
                                    </tr>
                                <?php } ?>

                            </table>

                            <br>
                            <hr>
                            <h3>Outbox Table</h3>
                            <table class="table table-striped">
                                <tr>
                                    <th>Doc ID</th>
                                    <th>Doc Title</th>
                                    <th>Date</th>
                                    <th>Recipient</th>
                                    <th>Sent</th>
                                    <th>Received</th>
                                    <th>Replied</th>
                                    <th>Reply Received</th>
                                </tr>
                                <?php foreach ($track->track_outbox() as $row) { ?>
                                    <tr>
                                    <form action="tracking.php" method="post" >
                                        <td> <?php echo $row['doc_id']; ?></td>
                                        <td> <?php echo $row['doc_title']; ?></td>
                                        <td> <?php echo $row['create_on']; ?></td>
                                        <td> <?php echo $row['recipient']; ?></td>
                                        <td><input type="checkbox" name="conform_sent" value="1" <?php echo ($row['conform_sent'] == 1) ? "checked" : ""; ?>></td>
                                        <td><input type="checkbox" name="conform_received" value="1" <?php echo ($row['conform_received'] == 1) ? "checked" : ""; ?>></td>
                                        <td><input type="checkbox" name="conform_replied" value="1" <?php echo ($row['conform_replied'] == 1) ? "checked" : ""; ?>></td>
                                        <td><input type="checkbox" name="conform_replied_received" value="1" <?php echo ($row['conform_replied_received'] == 1) ? "checked" : ""; ?>></td>
                                        <input type="hidden" name="doc_id" value="<?php echo $row['doc_id']; ?>">
                                        <td><input type="submit" value="Submit" name="submit"></td>
                                        <input type="hidden" value="inbox" name="type">
                                    </form>
                                    </tr>
                                <?php } ?>
                            </table> 
                        </div>
                    </div>
            </section>
        <?php } ?>
        <!--start-->
        <div class="modal" id="change_pass" >
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4>Change password</h4>
                    </div>
                    <div class="modal-body modal-sm">
                        <div class="form-group">
                            <form action="" method="post">
                                <input type="password" class="form-control" name="prev_pass" placeholder="Enter cuerrent Password"><br>
                                <input type="password" class="form-control"  name="new_pass" placeholder="Enter new Password"><br>
                                <input type="password" class="form-control"  name="con_pass" placeholder="confirm new Password"><br>
                                <input type="submit">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end-->
        <footer>
            <p>Copyright 2015, All Rights Reserved</p>
        </footer>
        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->

        <script src="lib/js/jquery.tablesorter.js"></script>
        <script>
            $(function () {
                $('#sort-table').tablesorter({
                    sortList: [[0, 0], [1, 0]]
                });
            });
        </script>
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
            $('#cat_id').change(function () {
                $('input[name=cat_id]').val($('#cat_id').val());
            });
            $('#sort').change(function () {
                $('input[name=sort]').val($('#sort').val());
            });

            //                end
        </script>
    </body>
</html>
