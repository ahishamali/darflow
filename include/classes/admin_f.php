<?php

class login_Admin extends connection {

    public $conn;
    public function login_A($user_name, $user_password, $user_type = NULL) {
        $this->test_input($user_name);
        $this->test_input($user_password);
        $this->test_input($user_type);
        $result = $this->conn->query("select * from users where user_name = '$user_name' and user_password = '$user_password'");
        if ($result->num_rows === 1) {
            $data = $result->fetch_assoc();
                switch ($data['user_type']) {
                    case 'admin':
                        $_SESSION['user_id'] = $data['user_id'];
                        $_SESSION['user_name'] = $data['user_name'];
                        $_SESSION['user_password'] = $data['user_password'];
                        $_SESSION['user_type'] = $data['user_type'];
                        return TRUE;
                     break;
                    case 'inserter':
                        $_SESSION['user_id'] = $data['user_id'];
                        $_SESSION['user_name'] = $data['user_name'];
                        $_SESSION['user_password'] = $data['user_password'];
                        $_SESSION['user_type'] = $data['user_type'];
                        return TRUE;
                     break;
                    case 'viewer':
                        $_SESSION['user_id'] = $data['user_id'];
                        $_SESSION['user_name'] = $data['user_name'];
                        $_SESSION['user_password'] = $data['user_password'];
                        $_SESSION['user_type'] = $data['user_type'];
                        return TRUE;
                     break;
                    default :
                        return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    public function get_session() {
        return $_SESSION['user_id'];
    }

    public function end_session() {
        $_SESSION['Login'] = FALSE;
        session_destroy();
        session_unset();
    }

    public function set_users($user_name, $user_password, $user_type){
        $this->test_input($user_name);
        $this->test_input($user_password);
        $this->test_input($user_type);
        $result = $this->conn->query("insert into users values ('','$user_name', '$user_password', '$user_type')");
        if ($result) {
          return TRUE;        
        }
        else {
            return FALSE;
}
    
}

// public function get_users() {
//        $result = $this->conn->query("select * from users");
//        return $result;
//    }
//    }
    
    public function get_users($cond = FALSE){
        if ($cond === FALSE){
            $result = $this->conn->query("select * from users");
        }  else {
            $result = $this->conn->query("select * from users order by user_id desc limit 3");
        }
        return $result;
    }
   
    public function delete_user($user_id){
        $result= $this->conn->query("delete from users where user_id = '$user_id'");
        if ($this->conn->affected_rows == 1){
            return TRUE;
        }  else {
            return FALSE;
        }
    }
    
}

    

?>