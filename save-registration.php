<?php ob_start();
$page_title = 'Saving you Registration..';
require('header.php');
?>

<?php 

try {
    // initialize variables
    $email = null;
    $password = null;
    $confirm = null;
    $user_id = null;
    
    // store the form inputs in variables
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];
    $user_id = $_POST['user_id'];
    $ok = true;

    // validation
    if (empty($email)){
        echo 'Email is required<br />';
        $ok = false;
    }

    if (empty($password)){
        echo 'Password is required<br />';
        $ok = false;
    }

    if ($password != $confirm){
        echo 'Passwords must match<br />';
        $ok = false;
    }
    
    // save if the form is ok 
    if($ok == true){
        require('db.php'); // connection 
        
        // set up the SQL command to save the data
        if (empty($user_id)) {
            $sql = "INSERT INTO admins (email, password) 
            VALUES (:email, :password)";
        }
        else {
            $sql = "UPDATE admins SET email = :email, password = :password WHERE user_id = :user_id";
        }
        
        // hash password 
        $hashed_password = hash('sha512', $password);
        
        // create a command object
        $cmd = $conn->prepare($sql);
        
        // input each value into the proper field 
        $cmd->bindParam(':email', $email, PDO::PARAM_STR, 100);
        $cmd->bindParam(':password', $hashed_password, PDO::PARAM_STR, 128);
        
        // add the registrant_id if available
        if (!empty($user_id)) {
            $cmd -> bindParam(':user_id', $user_id, PDO::PARAM_INT);
        }
        
        // save
        $cmd->execute();
        
        // disconnect
        $conn = null; // disonnect
        
        // redirect
        header('location:admins.php');
        
    }
}
catch (Exception $e) {
    mail('jack.grunin@gmail.com', 'Registration Error', $e);
    header('location:error.php');
}

?>

<?php require('footer.php'); 
ob_flush(); ?>