<?php
class ReturnRequest{
    private $con;

    function __construct() {
        include_once(__DIR__ . "/../database/db.php");
        $db = new Database();
        $this->con = $db->connect();

        
    }
    public function add($userId, $itemId) {
        echo $itemId;
        $query = "INSERT INTO return_requests (user_id, item_id, request_date, status) VALUES ($userId, $itemId, NOW(), 'Pending')";
        $stmt = $this->con->prepare($query);
        
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
