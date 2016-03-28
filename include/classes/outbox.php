<?php

class outbox extends connection {

    public function throw_outbox($doc_id, $doc_title, $sender_name, $recipient, $created_by, $attachment, $comment, $path, $reply, $cat_id, $updated_on, $updated_by, $issued_date) {
        $this->test_input($doc_id);
        $this->test_input($doc_title);
        $this->test_input($sender_name);
        $this->test_input($recipient);
        $this->test_input($created_by);
        $this->test_input($attachment);
        $this->test_input($comment);
        $this->test_input($path);
        $this->test_input($reply);
        $this->test_input($cat_id);
        $this->test_input($updated_on);
        $this->test_input($updated_by);
        $this->test_input($issued_date);

        $result = $this->conn->query("insert into outboxes values ('','$doc_id' ,'$doc_title','$sender_name','$recipient',now(),'$created_by','$attachment','$comment','$path','$reply', '$cat_id', '$updated_on', '$updated_by', '$issued_date')");
        if ($result) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function fetch_outbox($doc_title) {
        $result = $this->conn->query("select * from outboxes where doc_title like '%$doc_title%'");
        return $result;
    }
    
    public function display_latest($count) {
        $result = $this->conn->query("select * from outboxes order by create_on desc limit $count");
        return $result;
    }
    
    public function get_title_by_id($doc_id) {
        $result = $this->conn->query("select * from outboxes where doc_id = '$doc_id'");
        $result = $result->fetch_assoc();
        return $result['doc_title'];
    }
    
    public function get_by_cat_id($cat_id) {
        $result = $this->conn->query("select * from outboxes where cat_id = '$cat_id'");
        return $result;
    }
    
    public function get_by_id($doc_id) {
        $result = $this->conn->query("select * from outboxes where doc_id = '$doc_id'");
        return $result;
    }

}

?>
