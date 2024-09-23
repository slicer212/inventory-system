<?php
session_start();
if (!isset($_SESSION['userid']) || $_SESSION['usertype'] != 'Admin') {
    header("location:index.php");
    exit();
}

include_once("./database/db.php");
include_once("./includes/manages.php");

$m = new Manage();
$borrowRequests = $m->getAllBorrowRequests();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Manage Borrow Requests</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="./js/borrowed_item.js"></script>
</head>
<body>
    <div class="container">
        <h1 class="my-4">Borrow Requests</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Item Name</th>
                    <th>Category</th>
                    <th>User</th>
                    <th>Request Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($borrowRequests as $request) : ?>
                    <tr>
                        <td><?= $request['id'] ?></td>
                        <td><?= $request['item_name'] ?></td>
                        <td><?= $request['category'] ?></td>
                        <td><?= $request['username'] ?></td>
                        <td><?= $request['request_date'] ?></td>
                        <td><?= $request['status'] ?></td>
                        <td>
                            <button class='btn btn-success accept-request' data-id='<?= $request['id'] ?>'>Accept</button>
                            <button class='btn btn-danger reject-request' data-id='<?= $request['id'] ?>'>Reject</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>