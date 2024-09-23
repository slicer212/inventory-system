<?php 
include_once("../database/constant.php");
include_once("add_category.php");
include_once("user.php");
include_once("manages.php");

if (isset($_POST["username"], $_POST["email"])) {
    $user = new User();
    $result = $user->createUserAccount($_POST["username"], $_POST["email"], $_POST["password1"], $_POST["usertype"]);
    echo $result;
    exit();
}

if (isset($_POST["category_name"]) && isset($_POST["parent_cat"])) {
    $category_name = trim($_POST["category_name"]);
    $parent_cat = (int)$_POST["parent_cat"];

    if (empty($category_name)) {
        echo json_encode(['status' => 'INVALID_INPUT']);
        exit();
    }

    $category = new AddCategory();
    $result = $category->addCategory($parent_cat, $category_name);
    echo $result;
    exit();
}
if (isset($_POST["getCategory"])) {
    $category = new AddCategory();
    $categories = $category->getAllCategories();
    echo $categories;
    exit();
}

if (isset($_POST["added_date"]) && isset($_POST["item_name"])) {
    $cid = (int)$_POST["select_cat"];
    $item_name = trim($_POST["item_name"]);
    $item_qty = (int)$_POST["item_qty"];
    $added_date = $_POST["added_date"];
    
    $m = new Manage();
    
    // Check if the item already exists in the database
    $existingItem = $m->getItemByName($item_name, $cid);
    
    if ($existingItem) {
        // If the item exists, update its quantity and set status to 'Available'
        $new_qty = $existingItem['item_stock'] + $item_qty;
        $status = ($new_qty > 0) ? '1' : '0'; // If stock is greater than 0, set status to 'Available'

        $result = $m->update_record('items', ['pid' => $existingItem['pid']], [
            'item_stock' => $new_qty,
            'i_status' => $status
        ]);
        
        if ($result === "UPDATED") {
            echo json_encode(['status' => 'SUCCESS', 'message' => 'Item quantity updated successfully.']);
        } else {
            echo json_encode(['status' => 'ERROR', 'message' => 'Failed to update item quantity.']);
        }
    } else {
        // If item doesn't exist, add it as a new item
        $result = $m->addItem($cid, $item_name, $item_qty, $added_date);
        
        if ($result) {
            echo json_encode(['status' => 'SUCCESS', 'message' => 'New item added successfully.']);
        } else {
            echo json_encode(['status' => 'ERROR', 'message' => 'Failed to add item.']);
        }
    }
    
    exit();
}

if (isset($_POST["manageCategory"])) {
    $m = new Manage();
    $result = $m->manageRecordWithPagination("categories", $_POST["pageno"]);
    $rows = $result["rows"];
    $pagination = $result["pagination"];
    
    if (count($rows) > 0) {
        $n = (($_POST["pageno"] -1) * 5)+1;
        foreach ($rows as $row) {
            ?>
            <tr>
                <td><?php echo $n; ?></td>
                <td><?php echo htmlspecialchars($row["category"]); ?></td>
                <td><?php echo htmlspecialchars($row["parent"]); ?></td>
                <td>
                    <a href="#" did="<?php echo $row['id']; ?>" class="btn btn-danger btn-sm del_cat">Delete</a>
                    <a href="#" eid="<?php echo $row['id']; ?>" class="btn btn-info btn-sm edit_cat">Edit</a>
                </td>
            </tr>
            <?php
            $n++;
        }
        ?>
        <tr><td colspan="5"><?php echo $pagination; ?></td></tr>
        <?php
    }
    exit();
}

if (isset($_POST["deleteCategory"])) {
    $id = $_POST["id"];
    error_log("Attempting to delete category with ID: $id");
    $m = new Manage();
    $result = $m->deleteRecord("categories", $id);
    error_log("Result of deletion: $result");
    echo $result;
}

if(isset($_POST["updateCategory"])){
    $m = new Manage();
    $result = $m->getSingleRecord("categories", "id", $_POST["id"]);
    echo json_encode($result);
    exit();
}

if(isset($_POST["update_category"])) {
    $m = new Manage();
    $id = $_POST["id"];
    $name = $_POST["update_category"];
    $parent = $_POST["parent_cat"];

    // Update the record in the database
    $result = $m->update_record("categories", ["id" => $id], [
        "parent_cat" => $parent,
        "category_name" => $name
    ]);

    // Check the result and return the appropriate response
    if ($result === "UPDATED") {
        echo "UPDATED";
    } else {
        echo "invalid_request";
    }
    exit();
}

//Items

if (isset($_POST["manageItems"])) {
    $m = new Manage();
    $result = $m->manageRecordWithPagination("items", $_POST["pageno"]);
    $rows = $result["rows"];
    $pagination = $result["pagination"];

    $response = [
        "rows" => $rows,
        "pagination" => $pagination
    ];

    echo json_encode($response);
    exit();
}

if (isset($_POST["deleteItem"])) {
    $pid = (int)$_POST["pid"];
    $m = new Manage();
    $result = $m->deleteRecord("items", $pid); // Use correct table and ID

    if ($result === "DELETED SUCCESSFULLY") {
        echo "DELETED SUCCESSFULLY";
    } else {
        echo "DELETION FAILED";
    }
    exit();
}

if(isset($_POST["updateItem"])){
    $m = new Manage();
    $result = $m->getSingleRecord("items","pid",$_POST["id"]);
    echo json_encode($result);
    exit();
}

if (isset($_POST["update_item"])) {
    $m = new Manage();
    $id = $_POST["pid"]; // get the ID from the form
    $name = $_POST["update_item"];
    $cat = (int)$_POST["select_cat"];
    $item_qty = (int)$_POST["item_qty"];
    $added_date = $_POST["added_date"];
    $status = $item_qty > 0 ? '1' : '0';

    // Ensure all fields are being updated correctly
    $result = $m->update_record("items", ["pid" => $id], [
        "cid" => $cat, 
        "item_name" => $name, 
        "item_stock" => $item_qty, 
        "added_date" => $added_date, 
        "i_status" => $status
    ]);
    
    echo $result;
    exit();
}

if (isset($_POST["borrowItem"])) {
    session_start(); // Ensure session is started
    $item = $_POST["item"];
    $userId = $_SESSION["userid"]; // Assume user is logged in
    $itemName = $item['name'];
    $itemCategory = $item['category'];
    $addedDate = $item['addedDate'];

    $m = new Manage();
    $result = $m->submitBorrowRequest($userId, $itemName, $itemCategory, $addedDate);

    if ($result) {
        echo json_encode(['status' => 'SUCCESS']);
    } else {
        echo json_encode(['status' => 'ERROR']);
    }
    exit();
}

if (isset($_POST['acceptBorrowRequest']) && isset($_POST['requestId'])) {
    $requestId = $_POST['requestId'];

    $m = new Manage();

    // First, update the borrow request status to 'Accepted'
    $m->updateBorrowRequestStatus($requestId, 'Accepted');

    // Then, move the borrow request to the currently borrowed items table
    if ($m->moveToCurrentlyBorrowed($requestId)) {
        // Reduce the item quantity after it's borrowed
        $borrowRequest = $m->getBorrowRequestById($requestId);
        $m->decreaseItemQuantity($borrowRequest['item_name']); // Decrease stock by 1

        echo "success";
    } else {
        echo "Failed to move the item to currently borrowed items.";
    }
    exit();
}
if (isset($_POST["returnItem"])) {
    $itemId = $_POST["itemId"];
    session_start();  // Ensure the session is started to get user info
    $userId = $_SESSION['userid'];
    
    $returnRequest = new ReturnRequest();
    
    $result = $returnRequest->add($userId, $itemId);
    $currentlyBorrowed = new CurrentlyBorrowed();
    $currentlyBorrowed->delete($itemId);
    
    if ($result) {
        echo "Item returned successfully.";
    } else {
        echo "Failed to return the item.";
    }
    exit();
}

if (isset($_POST['issueReturnRequest']) && isset($_POST['itemId'])) {
    $itemId = (int)$_POST['itemId'];
    session_start();  // Ensure the session is started to get user info
    $userId = $_SESSION['userid'];  // Assuming the user is logged in and session has user info

    $m = new Manage();
    $result = $m->submitReturnRequest($userId, $itemId);

    if ($result) {
        echo "success";  // Return success message
    } else {
        echo "error";  // Return error message if the request fails
    }
    exit();
}


if (isset($_POST['approveReturnRequest'])) {
    $requestId = $_POST['requestId'];
    
    $m = new Manage();
    
    // Fetch the details of the return request, including the item ID
    $requestDetails = $m->getReturnRequestDetails($requestId);
    
    if ($requestDetails && $requestDetails['status'] == 'Pending') {
        // Approve the return request by updating its status
        $isApproved = $m->approveReturnRequest($requestId);
        
        if ($isApproved) {
            // Increase the item quantity in the inventory
            $itemId = $requestDetails['item_id'];
            $updateQuantity = $m->increaseItemQuantity($itemId);
            
            if ($updateQuantity) {
                echo 'success';
            } else {
                echo 'failed_to_update_quantity';
            }
        } else {
            echo 'failed_to_approve';
        }
    } else {
        echo 'invalid_request';
    }
    exit();
}

if (isset($_POST['itemId'])) {
    $itemId = $_POST['itemId'];

    $manage = new Manage();

    // Call the function to return the borrowed item
    if ($manage->returnBorrowedItem($itemId)) {
        echo 'success';
    } else {
        echo 'error';
    }
} else {
    echo 'invalid_request';
}
?>