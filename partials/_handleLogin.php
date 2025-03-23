<?php
include("_dbconnect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['loginEmail'];
    $pass = $_POST['loginPassword'];
    $sql = "SELECT * FROM `users` WHERE user_email='$email'";
    $result = mysqli_query($conn, $sql);
    $numRows = mysqli_num_rows($result);

    if ($numRows == 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($pass, $row["user_pass"])) {
            session_start();
            $_SESSION["loggedin"] = true;
            $_SESSION["user_email"] = $email;
            header("location: ../index.php");
            exit();
        } else {
            header("location: ../index.php?password=invalid");
            exit();
        }
    } else {
        header("location: ../index.php?loggedin=invalid");
        exit();
    }
}

