<?php
class User {
    private mysqli $con;

    public function __construct(){
        include_once("../database/db.php");
        $db = new Database();
        $this->con = $db->connect();
    }

    private function emailExist(string $email): bool {
        $pre_stmt = $this->con->prepare("SELECT id FROM user WHERE email = ?");
        $pre_stmt->bind_param("s", $email);
        $pre_stmt->execute();
        $result = $pre_stmt->get_result();

        return $result->num_rows > 0;
    }

    public function createUserAccount(string $username, string $email, string $password, string $usertype): string {
        if ($this->emailExist($email)) {
            return "EMAIL_ALREADY_EXIST";
        } else {
            $pass_hash = password_hash($password, PASSWORD_BCRYPT, ["cost" => 8]);
            $date = date("Y-m-d");
            $notes = "";
            $pre_stmt = $this->con->prepare("INSERT INTO `user`(`username`, `email`, `password`, `usertype`, `register_date`, `last_login`, `notes`) 
            VALUES (?, ?, ?, ?, ?, ?, ?)");
            $pre_stmt->bind_param("sssssss", $username, $email, $pass_hash, $usertype, $date, $date, $notes);
            $result = $pre_stmt->execute();

            return $result ? "SUCCESS" : "SOME_ERROR";
        }
    }

    public function userLogin(string $email, string $password): int|string {
        $pre_stmt = $this->con->prepare("SELECT id, username, password, last_login, usertype FROM user WHERE email = ?");
        $pre_stmt->bind_param("s", $email);
        $pre_stmt->execute();
        $result = $pre_stmt->get_result();
    
        if ($result->num_rows < 1) {
            return "USER_NOT_FOUND";
        } else {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row["password"])) {
                $_SESSION["userid"] = $row["id"];
                $_SESSION["username"] = $row["username"];
                $_SESSION["usertype"] = $row["usertype"];
                $_SESSION["last_login"] = $row["last_login"];
    
                $last_login = date("Y-m-d");
                $pre_stmt = $this->con->prepare("UPDATE user SET last_login = ? WHERE email = ?");
                $pre_stmt->bind_param("ss", $last_login, $email);
                $pre_stmt->execute();

                return 1;
            } else {
                return "INCORRECT_PASSWORD";
            }
        }
    }
}
?>