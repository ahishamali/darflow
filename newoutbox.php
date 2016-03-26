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
$errors = array();
if (isset($_REQUEST['doc_id'], $_REQUEST['doc_title'], $_REQUEST['recipient'], $_REQUEST['sender_name'], $_REQUEST['cat_id'], $_FILES['doc'])) {

    $doc = $_FILES['doc'];
    $doc_id = $outbox->test_input($_REQUEST['doc_id']);
    $doc_title = $outbox->test_input($_REQUEST['doc_title']);
    $recipient = $outbox->test_input($_REQUEST['recipient']);
    $sender_name = $outbox->test_input($_REQUEST['sender_name']);
    $cat_id = $outbox->test_input((int) $_REQUEST['cat_id']);
    $attachment = '';
    if (isset($_FILES['attach_doc'])) {
        $attachment = 'documents/' . $_FILES['attach_doc']['name'];
    } elseif (isset($_REQUEST['attach_other'])) {
        $attachment = $outbox->test_input($_REQUEST['attach_other']);
    }
    $comment = (isset($_REQUEST['comment'])) ? $outbox->test_input($_REQUEST['comment']) : NULL;
    $reply = (isset($_REQUEST['reply'])) ? $_REQUEST['reply'] : 0;
    $issued_date = (isset($_REQUEST['issued_date'])) ? $_REQUEST['issued_date'] : NULL;

    if (!empty($doc_id) && !empty($doc_title) && !empty($recipient) && !empty($sender_name) && !empty($cat_id)) {
        $filename = 'documents';
        $type = array('application/pdf', 'image/png', 'image/jpeg', 'image/jpg', 'image/gif');
        if (file_exists($filename)) {
            if (in_array($doc['type'], $type)) {
                if ($doc['size'] <= 5242880) {
                        $path = $filename . '/' . $doc['name'];
                    move_uploaded_file($doc['tmp_name'], $path);
                    $outbox->throw_outbox($doc_id, $doc_title, $sender_name, $recipient, $_SESSION['user_id'], $attachment, $comment, $path, $reply, $cat_id, 0, 0, $issued_date);
                    $success['insert'] = '<div class="alert alert-dismissible alert-success text-center">
                <strong>Well done! </strong>successfully inserted
            </div>';
                } else {
                    $errors[] = '<div class="alert alert-dismissible alert-danger text-center">
								<strong>Ops! </strong> The upload file is to large
								</div>';
                }
            } else {
                $errors[] = '<div class="alert alert-dismissible alert-danger text-center">
                <strong>Ops! </strong> Wrong file format error only:(jpg, pdf, png)
            </div>';
            }
        } else {
            mkdir($filename);
        }
    } else {
        $errors[] = '<div class="alert alert-dismissible alert-danger text-center">
								<strong>Ops! </strong> Your submit can not be empty or spaces
								</div> ';
    }
} else {
    $errors[] = '<div class="alert alert-dismissible alert-danger text-center">
								<strong>Ops! </strong>Your submit need at least four input
								</div>';
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>DarFlow - New Outbox</title>
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
                        <li><a href="cms/index.php">Admin Panel</a></li>
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
			<?php echo (isset($success['insert']))?$success['insert']:''; ?>
            <?php echo (isset($errors[0]))?$errors[0]:''; ?>
            
            <section>
                <div class="container">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="list-group">
                                <a href="archive.php" class="list-group-item active">
                                    <i class="fa fa-file"></i> Archive
                                </a>
                                <a href="inbox.php" class="list-group-item"><i class="fa fa-download"></i> Inbox</a>
                                <a href="outbox.php" class="list-group-item"><i class="fa fa-upload"></i> Outbox</a>
                                <a href="categories.php" class="list-group-item"><i class="fa fa-th"></i> Categories</a>

                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div  class="col-md-12">
                                    <h1 class="page-header"> <i class="fa fa-pencil-square-o"></i> Add New Outbox</h1>
                                </div>

                            </div>

                            <form action="newoutbox.php" method="post" enctype="multipart/form-data">

                                <div class="form-group">
                                    <input name="doc" type="file" >
                                </div>
                                <div class="form-group">
                                    <label>Doc ID</label>
                                    <input name="doc_id" type="text" class="form-control" placeholder="Enter the Document ID" required>
                                </div>
                                <div class="form-group">
                                    <label>Document Title</label>
                                    <input name="doc_title" type="text" class="form-control" placeholder="Enter Document Title" required>
                                </div>
                                <div class="form-group">
                                    <label>Sender Name</label>
                                    <input name="sender_name" type="text" class="form-control" placeholder="Enter Sender" required>
                                </div>
                                <div class="form-group">
                                    <label>Recipient</label>
                                    <input name="recipient" type="text" class="form-control" placeholder="Enter Recipient" required>
                                </div>
                                <div class="form-group">
                                    <label>Attachment</label>
                                        <select name="category" class="form-control">
        <option selected="" disabled="">--select one--</option>
    	<option value="1">Document</option></div>
        <option value="2">Thing</option>
    </select>

  </div>
        <div class="form-group">
         <input name="attach_doc" type="file">
         <textarea class="form-control" name="attach_other" rows="3" id="textArea" placeholder="name of attachment....."></textarea>
    </div>
                   
                                
                                <div class="form-group">
                                    <label>Category</label>
                                    <select id="inp" name="cat_id" class="form-control">
                                        <option selected="" disabled="" value="attach">--Category--</option>
                                        <?php foreach ($cat->get_cat() as $row) { ?>
                                            <option  value="<?php echo $row['cat_id']; ?>"><?php echo $row['cat_title']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Date</label>
                                    <input name="date" type="date" class="form-control">
                                </div>

                                <div class="form-group">
                                    <textarea class="form-control" name="comment" rows="3" id="textArea" placeholder="Comment here....."></textarea>
                                </div>
                                <div class="form-group">
                                    <input name="tracking" type="checkbox" >&nbsp;&nbsp;Add to Tracking?
                                </div>
                                <button type="submit" class="btn btn-default">Insert</button>
                            </form>


                        </div>
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
                                <input type="password" class="form-control" required="" name="prev_pass" placeholder="Enter cuerrent Password"><br>
                                <input type="password" class="form-control" required="" name="new_pass" placeholder="Enter new Password"><br>
                                <input type="password" class="form-control" required="" name="con_pass" placeholder="confirm new Password"><br>
                                <input type="submit">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end-->
        <footer>
            <p>Copyright 2015, All Rights Reserved DarFlow</p>
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
