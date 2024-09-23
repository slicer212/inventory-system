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
    <br/><br/>
    <div class="container">
    <?php
    session_start();
    if (!isset($_SESSION['userid'])) {
    header("location:index.php");
    }
    if (isset($_SESSION['usertype']) && $_SESSION['usertype'] != "Admin"){
        header("location:user_dashboard.php");
    }
    ?>
        <div class="row">
            <div class="col-md-4">
                <div class="card profile-card mx-auto">
                    <img class="card-img-top mx-auto" style="width:60%; margin-top: 20px;" src="./images/user.png" alt="User profile picture">
                    <div class="card-body text-center">
                        <h5 class="card-title">Profile Info</h5>
                        <p class="card-text">
                        <strong>Name:</strong> <?php echo $_SESSION["username"]; ?><br>
                        <strong>User Type:</strong> <?php echo $_SESSION["usertype"]; ?><br>
                        <strong>Last Login:</strong> <?php echo $_SESSION["last_login"]; ?>
                        </p>
                        <a href="#" class="btn btn-primary btn-block">Edit Profile</a>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="jumbotron jumbotron-custom">
                    <h1 class="display-4">Welcome, <?php echo $_SESSION["username"]; ?></h1>
                    <p class="lead">Manage your inventory efficiently using the tools provided below.</p>
                    <hr class="my-4">
                    <div class="row">
                        <div class="col-sm-6">
                            <iframe src="https://free.timeanddate.com/clock/i9i4htyl/n2265/tlph/fs20/tct/pct/ftb/tt0/tm3/td1/th2" frameborder="0" width="349" height="25" allowtransparency="true"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="card card-custom">
                    <div class="card-body">
                        <h5 class="card-title">Categories</h5>
                        <p class="card-text">Manage and add new categories for your items.</p>
                        <a href="#" data-toggle="modal" data-target="#category" class="btn btn-primary">Add Categories</a>
                        <a href="manage_categories.php" class="btn btn-primary">Manage Categories</a>
                        
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-custom">
                    <div class="card-body">
                        <h5 class="card-title">Items</h5>
                        <p class="card-text">Manage your inventory items efficiently.</p>
                        <a href="#" data-toggle="modal" data-target="#items" class="btn btn-primary">Add Items</a>
                        <a href="manage_items.php" class="btn btn-primary">Manage Items</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-custom">
                    <div class="card-body">
                        <h5 class="card-title">Reports</h5>
                        <p class="card-text">Generate and view inventory reports.</p>
                        <a href="#" class="btn btn-primary">View Reports</a>
                    </div>
                </div>
            </div>
          
            <div class="col-md-4">
                <div class="card card-custom">
                    <div class="card-body">
                        <h5 class="card-title">View Borrowed Requests</h5>
                        <p class="card-text">View the list of borrowed items.</p>
                        <a href="borrowed_items.php" class="btn btn-primary">View Borrowed Items</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-custom">
                    <div class="card-body">
                        <h5 class="card-title">Return</h5>
                        <p class="card-text">Can Issues Return.</p>
                        <a href="admin_return_request.php" class="btn btn-primary">Issue Return</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-custom">
                    <div class="card-body">
                        <h5 class="card-title">Renew</h5>
                        <p class="card-text">Can Issues Renew.</p>
                        <a href="#" class="btn btn-primary">Issue Return</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php 
    include_once("./temp/category.php");
    ?>
    <?php 
    include_once("./temp/items.php");
    ?>


</body>
</html>