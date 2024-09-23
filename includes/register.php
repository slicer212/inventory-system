<?php
include_once("../database/constant.php");
include_once("user.php");

if (isset($_POST["username"], $_POST["email"], $_POST["password1"],  $_POST["password2"], $_POST["usertype"])) {

    $user = new User();
    $result = $user->createUserAccount($_POST["username"], $_POST["email"], $_POST["password1"], $_POST["usertype"]);

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