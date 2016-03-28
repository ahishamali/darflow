<?php

class login extends connection {

    public function login_f($user_name, $user_password) {
        $this->test_input($user_name);
        $this->test_input($user_password);
        $result = $this->conn->query("select * from users where user_name = '$user_name' and user_password = '$user_password'");
        if ($result->num_rows === 1) {
            $data = $result->fetch_assoc();
            if ($data['user_status'] === '1') {
                $_SESSION['user_id'] = $data['user_id'];
                $_SESSION['user_name'] = $data['user_name'];
                $_SESSION['user_type'] = $data['user_type'];
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    public function get_session() {
        return (isset($_SESSION['user_id'])) ? $_SESSION['user_id'] : FALSE;
    }

    public function end_session() {
        session_destroy();
        session_unset();
    }

}

?>