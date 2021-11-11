<?php
session_start();
require 'connection.php';
if(isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['agree']))
    if($_POST['first_name']!="" && $_POST['last_name']!="" && $_POST['email']!="" && $_POST['password']!="" && $_POST['agree']=="agree"){

        $full_name = $_POST["first_name"]." ".$_POST["last_name"];
        $email = $_POST["email"];
        $password = hash('sha256', $_POST["password"]);
    }
    else {
        die("Please, fill all fields and try again");
    }

$query = "SELECT email FROM users WHERE email =?";
$stmt = $connection->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if($row = $result->fetch_assoc()){
        $_SESSION['signup_error']= 'Email already exists.. Try another one';
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        
}
else{
        $query1 = "INSERT INTO users(email, password, full_name) VALUES (?,?,?)";
        $stmt1  = $connection->prepare($query1);
        $stmt1->bind_param("sss", $email, $password, $full_name);
        $stmt1->execute();
        $stmt1->close();
        $connection->close();
        unset($_SESSION['signup_error']);
        $_SESSION['name']= $full_name;
        header("location:home.php");
        
    }
?>