<?php
session_start();
require 'connection.php';

if(isset($_POST['email']) && isset($_POST['password']) && $_POST['email'] !="" && $_POST['password'] !=""){

        $email = $_POST['email'];
        $password = hash('sha256', $_POST['password']);

    }

    else{
        die("Try again later");
    }

$query = "SELECT email, password, full_name FROM users WHERE email =?";
$stmt = $connection->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if($row = $result->fetch_assoc()){
    if($row["password"] == $password){
        $_SESSION['name']=$row['full_name'];
        unset($_SESSION['login_error']);
        header("Location:home.php");
    }
    else{
        $_SESSION['login_error']= 'Wrong password.. Try again, please!';
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
}
    else{
        $_SESSION['login_error']= 'Email not found.. Try again or create an account if you do not have one!';
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }





?>