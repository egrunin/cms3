<?php ob_start();
require('auth.php');
$page_title = 'Saving your page..';
require('header.php');
?>
<?php

 try {
     // initialize variables
    $page_title = null;
    $page_info = null;
    $page_id = null;
    
    // store the form inputs in variables
    $page_title = $_POST['page_title'];
    $page_info = $_POST['page_info'];
    $page_id = $_POST['page_id'];
    
    // validate our inputs
    $ok = true;
     
    if (empty($page_title)) {
        echo 'Title must be added!<br />';
        $ok = false;
    }
    if (empty($page_info)) {
        echo 'Info must be added!<br />';
        $ok = false;
    }
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
            echo 'Image must be a JPG or PNG<br />';
            $ok = false;  
        }
    }
    else {
        // if the user didnt upload a new logo, grab the existing logo name if there is one
        if (!empty($_POST['current_logo'])) {
            $final_name = $_POST['current_logo'];
        }
    }

    // check if the form is ok to save or not
    if ($ok == true) {
        // connect to the db
        require('db.php');
        // set up the SQL command to save the data
        if (empty($page_id)) {
            $sql = "INSERT INTO page (page_title, page_info, logo) VALUES (:page_title, :page_info, :logo)";
        } else {
            $sql = "UPDATE page SET page_title = :page_title, page_info = :page_info, logo = :logo WHERE page_id = :page_id";
        }
        
        // create a command object
        $cmd = $conn->prepare($sql);
        
        // input each value into the proper field 
        $cmd->bindParam(':page_title', $page_title, PDO::PARAM_STR);
        $cmd->bindParam(':page_info', $page_info, PDO::PARAM_STR);
        $cmd -> bindParam(':logo', $final_name, PDO::PARAM_STR, 255);
        
        // add the page_id if available
         if (!empty($page_id)) {
            $cmd -> bindParam(':page_id', $page_id, PDO::PARAM_INT);
        }
        
        //save
        $cmd->execute();
        
        //disconnect
        $conn = null;
        
        // redirect
        header('location:pages.php');
    }
 }
  catch (Exception $e) {
      mail('jack.grunin@gmail.com', 'Error', $e);
      header('location:error.php');
  }
?>
<?php require('footer.php');
ob_flush(); ?>
