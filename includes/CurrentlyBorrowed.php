<?php
class CurrentlyBorrowed{
    private $con;

    function __construct() {
        include_once(__DIR__ . "/../database/db.php");
        $db = new Database();
        $this->con = $db->connect();
        
    }
    public function delete($itemId) {
        $query = "DELETE FROM currently_borrowed_items WHERE id = $itemId";
        $stmt = $this->con->prepare($query);
        
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function add($requestId) {
        // Fetch the borrow request details
        $sql = "INSERT INTO currently_borrowed_items (user_id, item_name, item_category, borrow_date, due_date) 
                SELECT user_id, item_name, category, NOW(), DATE_ADD(NOW(), INTERVAL 1 DAY)
                FROM borrow_requests WHERE id = $requestId";
        $stmt = $this->con->prepare($sql);
    
        if (!$stmt) {
            die("Prepare failed: " . $this->con->error);
        }
    
        //$stmt->bind_param("i", $requestId);
    
        if ($stmt->execute()) {
            return true;
        } else {
            error_log("Error executing moveToCurrentlyBorrowed: " . $stmt->error);
            return false;
        }
    }
}
