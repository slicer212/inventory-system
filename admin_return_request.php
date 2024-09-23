<?php
session_start();
if (!isset($_SESSION['userid'])) {
    header("location:index.php");
    exit();
}
include_once("./includes/manages.php");

$m = new Manage();
$returnRequests = $m->getAllReturnRequests(); // Fetch only 'Pending' requests
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Return Requests</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
</head>
<body>
    <div class="container">
        <h1>Return Requests</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Item Name</th>
                    <th>User</th>
                    <th>Request Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($returnRequests as $index => $request) : ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= htmlspecialchars($request['item_name']) ?></td>
                    <td><?= htmlspecialchars($request['username']) ?></td>
                    <td><?= htmlspecialchars($request['request_date']) ?></td>
                    <td><?= htmlspecialchars($request['status']) ?></td>
                    <td>
                        <?php if ($request['status'] == 'Pending') : ?>
                            <button class="btn btn-success approve-return" data-request-id="<?= $request['id'] ?>">Approve</button>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<script>
$(document).on('click', '.approve-return', function() {
    var button = $(this); // Reference to the button that was clicked
    var requestId = button.data('request-id');
    
    $.post('./includes/process.php', { approveReturnRequest: true, requestId: requestId }, function(response) {
        if (response.trim() == 'success') {
            alert("Request approved successfully.");
            // Remove the row from the table
            button.closest('tr').fadeOut(500, function() {
                $(this).remove();
            });
        } else {
            alert("Failed to approve return request.");
        }
    });
});
</script>