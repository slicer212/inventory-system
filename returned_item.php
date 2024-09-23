<?php
include_once("./includes/manages.php"); // Include the Manage class

$manage = new Manage();
$returnedItems = $manage->getAllReturnedItems(); // Fetch returned items
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Returned Items</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>List of Returned Items</h1>
        
        <?php if (!empty($returnedItems)) { ?>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Item Name</th>
                    <th>Category</th>
                    <th>Borrow Date</th>
                    <th>Return Date</th>
                    <th>Borrowed By</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($returnedItems as $item) { ?>
                <tr>
                    <td><?= $item['item_name']; ?></td>
                    <td><?= $item['category']; ?></td>
                    <td><?= $item['borrow_date']; ?></td>
                    <td><?= $item['return_date']; ?></td>
                    <td><?= $item['username']; ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php } else { ?>
        <p>No items have been returned yet.</p>
        <?php } ?>
    </div>
</body>
</html>