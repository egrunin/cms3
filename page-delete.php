<?php ob_start();
// auth check 
require('auth.php'); ?>

<?php
try {
    // identify the record the user wants to delete
    $page_id = null;
    $page_id = $_GET['page_id'];

    if (is_numeric($page_id)) {
        // connect
        require('db.php'); 

        // prepare and execute the SQL DELETE command
        $sql = "DELETE FROM page WHERE page_id = :page_id";

        $cmd = $conn->prepare($sql);
        $cmd->bindParam(':page_id', $page_id, PDO::PARAM_INT);
        $cmd->execute();

        // disconnect
        $conn = null;

        // redirect back to the updated registrants.php
        header('location:pages.php');
    }
}
catch (Exception $e) {
    mail('jack.grunin@gmail.com', 'Page delete error', $e);
    header('location:error.php');
}

ob_flush(); ?>