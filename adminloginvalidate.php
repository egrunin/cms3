<?php ob_start();
include('header.php'); 

$email = $_POST['email'];
$password = hash('sha512', $_POST['password']);

require('db.php');

$sql = "SELECT user_id FROM admins WHERE email = :email AND password = :password";

$cmd = $conn->prepare($sql);
$cmd->bindParam(':email', $email, PDO::PARAM_STR, 100);
$cmd->bindParam(':password', $password, PDO::PARAM_STR, 128);
$cmd->execute();
$admins = $cmd->fetchAll();

$count = $cmd->rowCount();


if ($count == 0) {
	echo 'Invalid Login';
	//exit();	
}
    else {
        session_start(); // Access the existing user session created on the server
        
        foreach  ($admins as $admin) {
            $_SESSION['user_id'] = $admin['user_id'];
            header('location: admins.php');
        }
    }
$conn = null;

include('footer.php');
ob_flush(); ?>
