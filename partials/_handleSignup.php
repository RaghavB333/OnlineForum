<?php
$showError="false";
if($_SERVER["REQUEST_METHOD"]=="POST"){
    include("_dbconnect.php");
    $user_email=$_POST['signupEmail'];
    $pass=$_POST['signupPassword'];
    $cpass=$_POST['signupcPassword'];
    // if username already exists

    $existSql="SELECT * FROM `users` WHERE user_email='$user_email'";
    $result=mysqli_query($conn,$existSql);
    $numRows=mysqli_num_rows($result);
    if($numRows> 0){
        $showError="Username already in use";
        header("location:http://localhost/php-course/Online%20forum/index.php?signupsuccess=$showError");
    }
    else{
        if($pass==$cpass){
            $hash=password_hash($pass,PASSWORD_DEFAULT);
            $sql= "INSERT INTO `users` (`user_email`, `user_pass`, `timestamp`) VALUES ('$user_email', '$hash', current_timestamp())";
            $result=mysqli_query($conn,$sql);
            // $sql2="SELECT FROM `users` where `user_email`='$user_email'";
            // $result2=mysqli_query($conn,$sql2);
            // $sql3= "";
            if($result){
                $showAlert=true;
                header("location:http://localhost/php-course/Online%20forum/index.php?signupsuccess=true");
                exit();
            }
        }
        else{
            $showError="Passwords do not match";
            header("location:http://localhost/php-course/Online%20forum/index.php?signupsuccess=$showError");


        }
        // header("location:index.php?signupsuccess=false&error=$showError");

    }
}