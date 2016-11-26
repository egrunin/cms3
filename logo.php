<?php ob_start();
// set title and show header
$page_title = 'Logo Upload';
require('header.php'); 
?>

<?php
// initialize an empty id variable
$user_id = null;

//check if we have a user id in the querystring
if (is_numeric($_GET['user_id'])) {

    //if we do, store in a variable
    $user_id = $_GET['user_id'];

    //connect
    require('db.php'); 

    //select all the data for the selected user
    $sql = "SELECT * FROM admins WHERE user_id = :user_id";
    $cmd = $conn->prepare($sql);
    $cmd->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $cmd->execute();
    $admins = $cmd->fetchAll();

    //disconnect
    $conn = null;

    //store each value from the database into a variable
    foreach ($admins as $admin) {
        $logo = $admin['logo'];
    }
}
?>

<h1>LOGO</h1>

<p>Choose your Image</p>
<form method="post" action="save-logo.php" enctype="multipart/form-data">
    <fieldset>
        <label for="logo" class="col-sm-2">Logo:</label>
        <input type="file" name="logo" id="logo"  />
    </fieldset>
    
    <?php if (!empty($logo)) {
    echo '<div class="col-sm-offset-2">
            <img title="Logo" src="images/' . $logo . '" class="img-circle" />
         </div>';
    }
    ?>
    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>" />
    <input type="hidden" name="current_logo" id="current_logo" value="<?php echo $logo; ?>" />
    <button class="btn btn-primary col-sm-offset-2">Upload</button>
</form>

<?php require('footer.php');
ob_flush(); ?>