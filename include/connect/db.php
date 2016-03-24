<?php

require 'constant.php';

class connection {

    public $conn;

    public function __construct() {
        $this->conn = new mysqli(host, user, pass, db);
    }
    
    public function test_input($param) {
        $param = trim($param);
        $param = stripslashes($param);
        $param = htmlspecialchars($param);
        $param = $this->conn->real_escape_string($param);
        return $param;
    }   

}

?>