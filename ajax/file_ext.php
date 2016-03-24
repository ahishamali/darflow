<?php

if (isset($_REQUEST['file'])){
    $file = $_REQUEST['file'];
    $ext = pathinfo($file, PATHINFO_EXTENSION);
    $type = array('pdf', 'png', 'jpg');
    if (in_array($ext, $type)){
        echo 'correct';
    }  else {
        echo 'wrong';
    }
}

?>