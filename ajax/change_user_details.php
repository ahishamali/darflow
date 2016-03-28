<?php

require '../include/connect/db.php';

$db = new connection();

if (isset($_REQUEST['type'],$_REQUEST['value'])){
    $type = $_REQUEST['type'];
    $value = $_REQUEST['value'];
    $id = $_REQUEST['id'];
    $result = $db->conn->query("update users set $type = '$value' where user_id = '$id'");
    if ($result){
        echo 'success';
    }  else {
        echo 'failed';
    }
}

?>