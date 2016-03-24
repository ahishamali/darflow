<?php

class cat extends connection{
    
    public function get_cat_by_id($id) {
        $result = $this->conn->query("select * from category where cat_id = '$id' limit 1");
        $data = $result->fetch_assoc();
        return $data['cat_title'];
    }
    
    public function get_cat() {
        $result = $this->conn->query("select * from category");
        return $result;
    }
    
     public function set_cat($cat_title){
        $this->test_input($cat_title);
        $result = $this->conn->query("insert into category values ('','$cat_title')");
        if ($result) {
          return TRUE;        
        }
        else {
            return FALSE;
}
    
}

public function delete_cat($cat_id){
        $result= $this->conn->query("delete from category where cat_id = '$cat_id'");
        if ($this->conn->affected_rows == 1){
            return TRUE;
        }  else {
            return FALSE;
        }
    }
    
}

?>