<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Inventory System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" type="text/css" href="./includes/style.css">
    <script src="./js/manage_item.js"></script>
    <style>
        .login-card {
            max-width: 400px;
            margin: 50px auto;
            padding: 30px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
        }

        .login-card img {
            margin-bottom: 20px;
        }

        .navbar-custom {
            background-color: #343a40;
        }

        .navbar-custom .navbar-brand, .navbar-custom .nav-link {
            color: #ffffff;
        }

        .navbar-custom .nav-link:hover {
            color: #d4d4d4;
        }

        .profile-card {
            max-width: 20rem;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
        }

        .jumbotron-custom {
            background-color: #f8f9fa;
            padding: 2rem 2rem;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
        }

        .card-custom {
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .card-custom .card-body {
            text-align: center;
        }

        .card-custom .card-body .btn {
            margin-top: 10px;
            width: 100%;
        }
    </style>
</head>
<body>

    <?php
    include_once("./temp/header.php");
    ?>
    <div class="container">
    <table class="table table-hover table-bordered">
    <thead>
      <tr>
        <th>#</th>
        <th>Item</th>
        <th>Category</th>
        <th>Quantity</th>
        <th>Added Date</th>
        <th>Status</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody id="get_item">
      <!--<tr>
        <td>1</td>
        <td>School Equipment</td>
        <td>Root</td>
        <td>
            <a href="#" class="btn btn-danger btn-sm">Delete</a>
            <a href="#" class="btn btn-info btn-sm">Edit</a>
        </td>
      </tr>
      <tr> -->
    </tbody>
  </table>
  <div id="pagination"></div>
</div>
</div>

<?php
include_once("./temp/update_items.php")
?>

</body>
</html>
<script>
    
</script>