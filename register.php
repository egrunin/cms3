<?php ob_start();

// set title and show header
$page_title = 'Register Admin';
require('header.php'); ?>

<?php
//initialize empty variable
$user_id = null;
$email = null;
$password = null;

//check for user id
if ((!empty($_GET['user_id'])) && (is_numeric($_GET['user_id']))) {
    // store in a variable
    $user_id = $_GET['user_id'];
    //connect
    require('db.php');
    //select all the data for the selected user
    $sql = "SELECT * FROM admins WHERE user_id = :user_id";
    $cmd = $conn->prepare($sql);
    $cmd->bindParam(':user_id', $user_id, PDO::PARAM_STR, 10);
    $cmd->execute();
    $admins = $cmd->fetchAll();
    //disconnect
    $conn = null;
    //store each value from the database into a variable
    foreach ($admins as $admin) {
        $email = $admin['email'];
        $password = $admin['password'];
    }
}
?>

<h1>Admin Registration</h1>
<form method="post" action="save-registration.php" class="form-horizontal">
<div class="form-group">
    <label for="email" class="col-sm-2">email:</label>
    <input name="email" required placeholder="email@host.com" value="<?php echo $email; ?>" />
</div>
<div class="form-group">
    <label for="password" class="col-sm-2">Password:</label>
    <input type="password" name="password" placeholder="password" value="<?php echo $password; ?>" />
</div>
<div class="form-group">
    <label for="confirm" class="col-sm-2">Confirm Password:</label>
    <input type="password" name="confirm" />
</div>
<input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id; ?>" />
<input type="submit" value="Save" class="btn btn-primary" />
</form>


<?php require('footer.php'); 
ob_flush ?>