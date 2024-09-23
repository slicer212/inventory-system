<?php
include_once("./database/db.php");
include_once("./includes/manages.php");

if (isset($_POST['requestId']) && isset($_POST['action'])) {
    $requestId = (int)$_POST['requestId'];
    $action = $_POST['action'];

    $m = new Manage();

    if ($action == 'accept') {
        // Accept the borrow request and decrease the item stock
        $borrowRequest = $m->getBorrowRequestById($requestId);

        if ($borrowRequest) {
            // Get the item details based on the borrow request
            $item = $m->getSingleRecord('items', 'item_name', $borrowRequest['item_name']);

            if ($item && $item['item_stock'] > 0) {
                // Decrease the item stock
                $newStock = $item['item_stock'] - 1;
                
                // Update the item stock
                $m->update_record('items', ['pid' => $item['pid']], [
                    'item_stock' => $newStock,
                    'i_status' => $newStock > 0 ? '1' : '0' // Update availability status
                ]);

                // Move the borrow request to currently borrowed items
                $m->moveToCurrentlyBorrowed($requestId);

                // Approve the borrow request
                $m->updateBorrowRequestStatus($requestId, 'Accepted');
                
                echo 'success';
            } else {
                echo 'error: no stock available';
            }
        } else {
            echo 'error: invalid borrow request';
        }
    } elseif ($action == 'reject') {
        // Reject the borrow request
        $m->updateBorrowRequestStatus($requestId, 'Rejected');
        echo 'success';
    }
}
?>