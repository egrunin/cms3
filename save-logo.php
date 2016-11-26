<?php ob_start();
require('auth.php');
$page_title = 'Upload Logo';
require('header.php');
?>

<?php 
// initialize variables
$logo = null;
$user_id = null;

// store the form inputs in variables
$logo = $_POST['logo'];
$user_id = $_POST['user_id'];

$ok = true;

// validate and process photo upload if we have one 
if (!empty($_FILES['logo']['name'])){
    $logo = $_FILES['logo']['name'];
    
    // get and check type 
    $type = $_FILES['logo']['type'];
    
    if (($type == 'image/png') || ($type == 'image/jpeg')) {
        // save the file - valid type
        $final_name = session_id() . "-" . $logo;
        $tmp_name = $_FILES['logo']['tmp_name'];
        move_uploaded_file($tmp_name, "images/$final_name");
    }
    else {
        echo 'Logo must be a JPG or PNG<br />';
        $ok = false;  
    }
}

// save if the form is ok 
if($ok == true){
    require('db.php'); // connection 
    
    // set up the SQL command to save the data
    if (empty($user_id)) {
        $sql = "INSERT INTO admins (logo) VALUES (:logo)";
    }
    else {
        $sql = "UPDATE admins SET logo = :logo WHERE user_id = :user_id";
    }
    
    // create a command object
    $cmd = $conn->prepare($sql);
    
    // input the value into the proper field 
    $cmd -> bindParam(':logo', $final_name, PDO::PARAM_STR, 255);
    
    // add the user_id if available
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
?>

<?php require('footer.php'); 
ob_flush(); ?>