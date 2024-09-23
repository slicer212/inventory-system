<?php
class Manage {
    private $con;

    function __construct() {
        include_once(__DIR__ . "/../database/db.php");
        $db = new Database();
        $this->con = $db->connect();
    }

    public function manageRecordWithPagination($table, $pno) {
        $a = $this->pagination($this->con, $table, $pno, 5);

        if ($table == "categories") {
            $sql = "SELECT c.id, c.category_name as category, 
                           IFNULL(p.category_name, 'Root') as parent 
                    FROM categories c 
                    LEFT JOIN categories p ON c.parent_cat = p.id 
                    " . $a["limit"];
        } else if ($table == "items") {
            $sql = "SELECT i.pid, i.item_name, c.category_name, i.item_stock, i.added_date, i.i_status 
                    FROM items i 
                    LEFT JOIN categories c ON i.cid = c.id 
                    " . $a["limit"];
        } else {
            $sql = "SELECT * FROM " . $table . " " . $a["limit"];
        }

        $result = $this->con->query($sql) or die($this->con->error);
        $rows = array();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
        }
        return ["rows" => $rows, "pagination" => $a["pagination"]];
    }

    private function pagination($con, $table, $pno, $n) {
        $query = $con->query("SELECT COUNT(*) as total_rows FROM " . $table);
        $row = mysqli_fetch_assoc($query);

        $pageno = $pno;
        $numberOfRecordsPerPage = $n;
        $last = ceil($row["total_rows"] / $numberOfRecordsPerPage);

        $pagination = "<ul class='pagination'>";

        if ($last != 1) {
            if ($pageno > 1) {
                $previous = $pageno - 1;
                $pagination .= "<li class='page-item'><a class='page-link' pn='".$previous."' href='#' style='color:#333'>Previous</a></li>";
            }
            for ($i = $pageno - 5; $i < $pageno; $i++) {
                if ($i > 0) {
                    $pagination .= "<li class='page-item'><a class='page-link' pn='".$i."' href='#'>" . $i . "</a></li>";
                }
            }
            $pagination .= "<li class='page-item'><a class='page-link' pn='".$pageno."' href='#' style='color:#333;'>$pageno</a></li>";
            for ($i = $pageno + 1; $i <= $last; $i++) {
                $pagination .= "<li class='page-item'><a class='page-link' pn='".$i."' href='#'>" . $i . "</a></li>";
                if ($i > $pageno + 5) {
                    break;
                }
            }
            if ($last > $pageno) {
                $next = $pageno + 1;
                $pagination .= "<li class='page-item'><a class='page-link' pn='".$next."' href='#' style='color:#333;'>Next</a></li></ul>";
            }
        } else {
            $pagination .= "</ul>";
        }

        $limit = "LIMIT " . (($pageno - 1) * $numberOfRecordsPerPage) . "," . $numberOfRecordsPerPage;

        return ["pagination" => $pagination, "limit" => $limit];
    }

    public function getItemByName($item_name, $cid) {
        $query = "SELECT * FROM items WHERE item_name = ? AND cid = ?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param("si", $item_name, $cid);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            return $result->fetch_assoc(); // Return the item data
        } else {
            return null; // Item not found
        }
    }
    
    public function addItem($cid, $item_name, $item_qty, $added_date) {
        $query = "INSERT INTO items (cid, item_name, item_stock, added_date, i_status) VALUES (?, ?, ?, ?, '1')";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param("isis", $cid, $item_name, $item_qty, $added_date);
        
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public function getBorrowRequestById($requestId) {
        $query = "SELECT * FROM borrow_requests WHERE id = ?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param("i", $requestId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return null;
    }

    public function deleteRecord($table, $id) {
        if ($table == "categories") {
            // Check if there are any dependent categories
            $pre_stmt = $this->con->prepare("SELECT id FROM categories WHERE parent_cat = ?");
            $pre_stmt->bind_param("i", $id);
            $pre_stmt->execute();
            $result = $pre_stmt->get_result();

            if ($result->num_rows > 0) {
                return "DEPENDENT CATEGORY";
            } else {
                // Delete the category
                $pre_stmt = $this->con->prepare("DELETE FROM categories WHERE id = ?");
                $pre_stmt->bind_param("i", $id);
                $result = $pre_stmt->execute();
                if ($result) {
                    return "CATEGORY DELETED";
                } else {
                    return "CATEGORY DELETION FAILED";
                }
            }
        } else if ($table == "items") {
            $pre_stmt = $this->con->prepare("DELETE FROM items WHERE pid = ?");
            $pre_stmt->bind_param("i", $id); // Bind the ID parameter correctly
            $result = $pre_stmt->execute() or die($this->con->error);
            if ($result) {
                return "DELETED SUCCESSFULLY";
            } else {
                return "DELETION FAILED";
            }
        } else {
            $pre_stmt = $this->con->prepare("DELETE FROM $table WHERE pid = ?");
            $pre_stmt->bind_param("i", $id);
            $result = $pre_stmt->execute() or die($this->con->error);
            if ($result) {
                return "DELETED SUCCESSFULLY";
            } else {
                return "DELETION FAILED";
            }
        }
    }
    
    public function getSingleRecord($table, $field, $value) {
        $query = "SELECT * FROM $table WHERE $field = ?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param("s", $value);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return null;
    }

    public function update_record($table, $where, $fields) {
        $sql = "UPDATE $table SET ";
        $params = [];
        $types = "";
        
        foreach ($fields as $key => $value) {
            $sql .= "$key = ?, ";
            $params[] = $value;
            $types .= "s"; // Adjust type as necessary, assuming string here
        }
        
        $sql = rtrim($sql, ", ");
        $sql .= " WHERE ";
        
        foreach ($where as $key => $value) {
            $sql .= "$key = ? AND ";
            $params[] = $value;
            $types .= "i"; // Adjust type as necessary, assuming integer here
        }
        
        $sql = rtrim($sql, " AND ");
        $stmt = $this->con->prepare($sql);
        
        if ($stmt === false) {
            return "UPDATE FAILED: " . $this->con->error;
        }
    
        $stmt->bind_param($types, ...$params);
        if ($stmt->execute()) {
            return "UPDATED";
        } else {
            return "UPDATE FAILED: " . $stmt->error;
        }
    }
    public function borrowItem($userId, $itemName, $itemCategory, $addedDate) {
        $query = "INSERT INTO borrowed_items (user_id, item_name, category, borrow_date) VALUES (?, ?, ?, ?)";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param("isss", $userId, $itemName, $itemCategory, $addedDate);
        
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function submitBorrowRequest($userId, $itemName, $itemCategory, $addedDate) {
        $query = "INSERT INTO borrow_requests (user_id, item_name, category, added_date) VALUES (?, ?, ?, ?)";
        $stmt = $this->con->prepare($query);
        
        if (!$stmt) {
            error_log("SQL Error: " . $this->con->error);  // Log SQL error if query preparation fails
            return false;
        }
        
        $stmt->bind_param("isss", $userId, $itemName, $itemCategory, $addedDate);
        
        if ($stmt->execute()) {
            return true;
        } else {
            error_log("Execution Error: " . $stmt->error);  // Log execution error if query fails
            return false;
        }
    }
    

    public function getAllBorrowRequests() {
        $query = "SELECT br.id, br.item_name, br.category, br.request_date, br.status, u.username 
                  FROM borrow_requests br 
                  JOIN user u ON br.user_id = u.id 
                  WHERE br.status = 'Pending'";
        $result = $this->con->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function updateBorrowRequestStatus($requestId, $status) {
        $query = "UPDATE borrow_requests SET status = ? WHERE id = ?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param("si", $status, $requestId);
        return $stmt->execute();
    }
    
    public function decreaseItemQuantity($itemName) {
        $sql = "UPDATE items SET item_stock = item_stock - 1 WHERE item_name = ? AND item_stock > 0";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("s", $itemName);
        return $stmt->execute();
    }

    public function moveToCurrentlyBorrowed($requestId) {
        // Fetch the borrow request details
        $sql = "INSERT INTO currently_borrowed_items (user_id, item_name, item_category, borrow_date, due_date) 
                SELECT user_id, item_name, category, NOW(), DATE_ADD(NOW(), INTERVAL 1 DAY)
                FROM borrow_requests WHERE id = ?";
        $stmt = $this->con->prepare($sql);
    
        if (!$stmt) {
            die("Prepare failed: " . $this->con->error);
        }
    
        $stmt->bind_param("i", $requestId);
    
        if ($stmt->execute()) {
            return true;
        } else {
            error_log("Error executing moveToCurrentlyBorrowed: " . $stmt->error);
            return false;
        }
    }
public function getCurrentlyBorrowedItems($userId) {
    $sql = "SELECT cbi.id, cbi.item_name, cbi.item_category, cbi.borrow_date, cbi.due_date , u.username 
            FROM currently_borrowed_items cbi 
            JOIN user u ON cbi.user_id = u.id";
    
    $result = $this->con->query($sql);
    
    if (!$result) {
        die("SQL Error: " . $this->con->error);
    }

    $items = [];
    while ($row = $result->fetch_assoc()) {
        $items[] = $row;
    }
    return $items;
}
    public function getReturnRequestDetails($requestId) {
        $sql = "SELECT item_id, status FROM return_requests WHERE id = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("i", $requestId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    public function returnBorrowedItem($itemId) {
        // Remove the item from the 'currently_borrowed_items' table
        $query = "DELETE FROM currently_borrowed_items WHERE id = ?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param("i", $itemId);
        return $stmt->execute();
    }

    public function addReturnRequest($userId, $itemId){
        $query = "INSERT INTO return_requests (user_id, item_id, request_date, status) VALUES (?, ?, NOW(), 'Pending')";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param("ii", $userId, $itemId);
        return $stmt->execute();
    }

    public function submitReturnRequest($userId, $itemId) {
        // Insert the return request into the return_requests table
        $query = "INSERT INTO return_requests (user_id, item_id, request_date, status) VALUES (?, ?, NOW(), 'Pending')";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param("ii", $userId, $itemId);
        
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public function increaseItemQuantity($itemId) {
        $sql = "UPDATE items SET quantity = quantity + 1 WHERE id = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("i", $itemId);
        return $stmt->execute();
    }
    
    // Admin approves return requests
    public function approveReturnRequest($requestId) {
        $sql = "UPDATE return_requests SET status = 'Approved' WHERE id = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("i", $requestId);
        return $stmt->execute();
        
        if ($result->num_rows > 0) {
            $request = $result->fetch_assoc();
            $itemId = $request['item_id'];
            $userId = $request['user_id'];
    
            // Get the item details from currently_borrowed_items
            $itemQuery = "SELECT item_name, category, borrow_date FROM currently_borrowed_items WHERE id = ?";
            $itemStmt = $this->con->prepare($itemQuery);
            $itemStmt->bind_param("i", $itemId);
            $itemStmt->execute();
            $itemResult = $itemStmt->get_result();
            $item = $itemResult->fetch_assoc();
    
            // Remove the item from currently_borrowed_items (mark as returned)
            $this->returnBorrowedItem($itemId);
    
            // Insert the returned item into the returned_borrowed_items table
            $insertQuery = "INSERT INTO returned_borrowed_items (user_id, item_name, category, borrow_date, return_date) VALUES (?, ?, ?, ?, NOW())";
            $insertStmt = $this->con->prepare($insertQuery);
            $insertStmt->bind_param("isss", $userId, $item['item_name'], $item['category'], $item['borrow_date']);
            $insertStmt->execute();
    
            // Update the return request status to 'Approved'
            $updateQuery = "UPDATE return_requests SET status = 'Approved' WHERE id = ?";
            $updateStmt = $this->con->prepare($updateQuery);
            $updateStmt->bind_param("i", $requestId);
            $updateStmt->execute();
    
            return true;
        } else {
            return false; // No pending request found
        }
    }
    
    public function getAllReturnRequests() {
        $query = "SELECT r.id, r.item_id, r.request_date, r.status, u.username, i.item_name 
                  FROM return_requests r 
                  JOIN user u ON r.user_id = u.id 
                  JOIN currently_borrowed_items i ON r.item_id = i.id 
                  WHERE r.status = 'Pending'";
                  
        $result = $this->con->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    public function getAllReturnedItems() {
        $query = "SELECT r.id, r.item_name, r.category, r.borrow_date, r.return_date, u.username
                  FROM returned_borrowed_items r 
                  JOIN user u ON r.user_id = u.id";
        $result = $this->con->query($query);
        
        return $result->fetch_all(MYSQLI_ASSOC); // Fetch results as an associative array
    }

    

}
?>