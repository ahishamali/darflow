<?php

class track extends connection {

    public function track_outbox() {

        $result = $this->conn->query("select outboxes.doc_id, outboxes.doc_title, outboxes.create_on, outboxes.recipient, tracking.conform_sent, tracking.conform_received, tracking.conform_replied,tracking.conform_replied_received from outboxes inner join tracking on outboxes.doc_id = tracking.doc_id");

        return $result;
    }

    public function track_inbox() {

        $result = $this->conn->query("select inboxes.doc_id, inboxes.doc_title, inboxes.create_on, inboxes.sender, tracking.conform_sent, tracking.conform_received, tracking.conform_replied, tracking.conform_replied_received from inboxes inner join tracking on inboxes.doc_id = tracking.doc_id");

        return $result;
    }
     public function submit_checkbox_inbox($doc_id, $conform_sent, $conform_received, $conform_replied, $conform_replied_received) {

        $result = $this->conn->query("update tracking set conform_sent='$conform_sent', conform_received = '$conform_received', conform_replied ='$conform_replied', conform_replied_received='$conform_replied_received' "
                . "where doc_id='$doc_id'");
    }
    public function submit_checkbox_outboxbox($doc_id, $conform_sent, $conform_received, $conform_replied, $conform_replied_received) {

        $result = $this->conn->query("update tracking set conform_sent='$conform_sent', conform_received = '$conform_received', conform_replied ='$conform_replied', conform_replied_received='$conform_replied_received' "
                . "where doc_id='$doc_id'");
    }
    
    public function display_pend() {
        $result = $this->conn->query("select * from tracking order by track_id limit 5");
        return $result;
    }
}

?>