<?php
session_start();
if (!isset($_SESSION['userid'])) {
    header("location:index.php");
    exit();
}

include_once("./database/db.php");
include_once("./includes/manages.php");
include_once("./includes/ReturnRequest.php");
include_once("./includes/CurrentlyBorrowed.php");

$m = new Manage();
$currentlyBorrowedItems = $m->getCurrentlyBorrowedItems($_SESSION['userid']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Currently Borrowed Items</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
</head>
<body>
    <div class="container">
        <h1 class="my-4">Currently Borrowed Items</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Item Name</th>
                    <th>Category</th>
                    <th>Borrowed By</th>
                    <th>Borrow Date</th>
                    <th>Due Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($currentlyBorrowedItems as $item) : ?>
                    <tr>
                        <td><?= $item['id'] ?></td>
                        <td><?= $item['item_name'] ?></td>
                        <td><?= $item['item_category'] ?></td>
                        <td><?= $item['username'] ?></td>
                        <td><?= $item['borrow_date'] ?></td>
                        <td><?= $item['due_date'] ?></td>
                        <td>
                            <button class='btn btn-warning return-item' data-id='<?= $item['id'] ?>'>Return</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<script>
    $(document).on('click', '.return-item', function () {
        const itemId = $(this).data('id');

        if (confirm('Are you sure you want to mark this item as returned?')) {
            $.ajax({
                url: './includes/process.php',
                method: 'POST',
                data: { itemId: itemId, returnItem: true },
                success: function (response) {
                    if (response.trim() === 'success') {
                        alert('Item returned successfully!');
                        location.reload();
                    } else {
                        alert('Failed to return the item.');
                    }
                },
                error: function () {
                    alert('Error processing return.');
                }
            });
        }
    });
    </script>