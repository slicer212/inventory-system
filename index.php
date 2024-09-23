<?php
include_once("./database/constant.php");
if(isset($_SESSION["userid"]))
header("location:" .DOMAIN."/dashboard.php");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Inventory System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <script type="text/javascript" rel="stylesheet" src="./js/main.js"></script>
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
    </style>
</head>
<body>
    <div class="overlay"><div class="loader"></div></div>

    <?php include_once("./temp/header.php"); ?>

    <?php if (isset($_GET['msg'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($_GET['msg']); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <br/><br/>
    <div class="container">
        <div class="card login-card">
            <img class="card-img-top mx-auto d-block" style="width: 50%;" src="./images/login.png" alt="login icon">
            <div class="card-body">
                <form id="login_form">
                    <div class="form-group">
                        <label for="log_email">Email address</label>
                        <input type="email" class="form-control" name="log_email" id="log_email" placeholder="Enter email">
                        <small id="e_error" class="form-text text-muted">We'll never share your email with anyone else.</small>
                    </div>
                    <div class="form-group">
                        <label for="log_password">Password</label>
                        <input type="password" class="form-control" name="log_password" id="log_password" placeholder="Password">
                        <small id="p_error" class="form-text text-muted"></small>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-lock"></i>&nbsp;Login</button>
                    <button type="button" class="btn btn-secondary btn-block"><a href="register.php" style="color:white;text-decoration:none;">Not Registered Yet?</a></button>
                </form>
            </div>
            <div class="card-footer"><a href="#">Forget Password?</a></div>
        </div>
    </div>
</body>
</html>