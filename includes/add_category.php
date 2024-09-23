<?php
class AddCategory {
    private mysqli $con;

    public function __construct(){
        include_once("../database/db.php");
        $db = new Database();
        $this->con = $db->connect();
    }

    public function addCategory($parent_cat, $category_name) {
        // Check if category already exists
        $pre_stmt = $this->con->prepare("SELECT * FROM categories WHERE category_name = ?");
        $pre_stmt->bind_param("s", $category_name);
        $pre_stmt->execute();
        $result = $pre_stmt->get_result();

        if ($result->num_rows > 0) {
            return json_encode(['status' => 'CATEGORY_EXISTS']);
        } else {
            // Insert new category
            $pre_stmt = $this->con->prepare("INSERT INTO categories (parent_cat, category_name) VALUES (?, ?)");
            $pre_stmt->bind_param("is", $parent_cat, $category_name);
            if ($pre_stmt->execute()) {
                $category_id = $this->con->insert_id;
                return json_encode(['status' => 'CATEGORY_ADDED', 'new_category' => ['id' => $category_id, 'category_name' => $category_name]]);
            } else {
                return json_encode(['status' => 'ERROR']);
            }
        }
    }
    public function getAllCategories() {
        $sql = "SELECT id, category_name FROM categories";
        $result = $this->con->query($sql);
        
        $categories = "";
        while ($row = $result->fetch_assoc()) {
            $categories .= "<option value='".$row['id']."'>".$row['category_name']."</option>";
        }
        return $categories;
    }
    public function addItem(int $cid, string $item_name, int $item_stock, string $date): string {
        $i_status = 1;
    
        $pre_stmt = $this->con->prepare("INSERT INTO `items`(`cid`, `item_name`, `item_stock`, `added_date`, `i_status`) 
        VALUES (?, ?, ?, ?, ?)");
    
        if ($pre_stmt === false) {
            return json_encode(['status' => 'ERROR', 'message' => $this->con->error]);
        }
    
        $pre_stmt->bind_param("isisi", $cid, $item_name, $item_stock, $date, $i_status);
    
        try {
            $pre_stmt->execute();
            return json_encode(['status' => 'SUCCESS', 'message' => 'Item added successfully']);
        } catch (mysqli_sql_exception $e) {
            return json_encode(['status' => 'ERROR', 'message' => $e->getMessage()]);
        }
    }
}
?>