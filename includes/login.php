<?php
include_once("../database/constant.php");
include_once("user.php");

if (isset($_POST["log_email"], $_POST["log_password"])) {
    $user = new User();
    $result = $user->userLogin($_POST["log_email"], $_POST["log_password"]);

    if ($result === 1) {
        echo "LOGIN_SUCCESS";
    } elseif ($result === "Account did not exist") {
        echo "NOT_REGISTERED";
    } elseif ($result === "Password does not match") {
        echo "INCORRECT_PASSWORD";
    } else {
        echo "USER_NOT_FOUND";
    }
} else {
    echo "INVALID_REQUEST";
}
?>