<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Inventory System - Register</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="./js/main.js"></script>
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
        .form-text.text-muted {
            color: #6c757d !important;
        }
    </style>
</head>
<body>
<div class="overlay"><div class="loader"></div></div>
    <?php include_once("./temp/header.php"); ?>

    <br><br>
    <div class="container">
        <div class="card mx-auto login-card">
            <div class="card-header text-center">Register</div>
            <div class="card-body">
                <form id="register_form" onsubmit="return false" autocomplete="off">
                    <div class="form-group">
                        <label for="username">Full Name</label>
                        <input type="text" name="username" class="form-control" id="username" placeholder="Enter Full Name">
                        <small id="u_error" class="form-text text-muted"></small>
                    </div>
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" name="email" class="form-control" id="email" placeholder="Enter Email">
                        <small id="e_error" class="form-text text-muted">We'll never share your email with anyone else.</small>
                    </div>
                    <div class="form-group">
                        <label for="password1">Password</label>
                        <input type="password" name="password1" class="form-control" id="password1" placeholder="Password">
                        <small id="p1_error" class="form-text text-muted"></small>
                    </div>
                    <div class="form-group">
                        <label for="password2">Re-enter Password</label>
                        <input type="password" name="password2" class="form-control" id="password2" placeholder="Re-enter Password">
                        <small id="p2_error" class="form-text text-muted"></small>
                    </div>
                    <div class="form-group">
                        <label for="usertype">User Type</label>
                        <select name="usertype" class="form-control" id="usertype">
                            <option value="">Select User Type</option>
                            <option value="Admin">Admin</option>
                            <option value="Faculty">Faculty/Staff</option>
                        </select>
                        <small id="t_error" class="form-text text-muted"></small>
                    </div>
                    <button type="submit" name="user_register" class="btn btn-primary btn-block">
                        <span class="fa fa-user"></span>&nbsp;Register
                    </button>
                    <span class="d-block text-center mt-2"><a href="index.php">Login</a></span>
                </form>
            </div>
        </div>
    </div>
</body>
</html>