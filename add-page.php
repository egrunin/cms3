<?php ob_start();
// authenticate
require('auth.php');
 // set title and show header
$page_title = 'Add Page';
require('header.php'); 
?>
<?php
//initialize empty variable
$page_id = null;
$page_title = null;
$page_info = null;

//check for ID in the querystring
if ((!empty($_GET['page_id'])) && (is_numeric($_GET['page_id']))) {

// select page_id and store in variable
$page_id = $_GET['page_id'];

//connect
require('db.php'); 

    //select all the data for the appropriate id
    $sql = "SELECT * FROM page WHERE page_id = :page_id";
    $cmd = $conn->prepare($sql);
    $cmd->bindParam(':page_id', $page_id, PDO::PARAM_INT);
    $cmd->execute();
    $page = $cmd->fetchAll();

    //store each value from the database into a variable
    foreach ($page as $data) {
        $page_title = $data['page_title'];
        $page_info = $data['page_info'];
        $logo = $data['logo'];
    }
    
    //disconnect
    $conn = null;
}
?>

<h1>Add Page</h1>
<p>* indicates Required Fields</p>
<form method="post" action="save-addpage.php" enctype="multipart/form-data" class="form-horizontal">
    <fieldset>
        <label for="page_title" class="col-sm-2">Page Title: *</label>
        <input name="page_title" id="page_title" required placeholder="Page Title" value="<?php echo $page_title; ?>" />
    </fieldset>
    <fieldset>
        <label for="page_info" class="col-sm-2">Page Info: *</label>
        <textarea name="page_info" rows="5"><?php echo $page_info; ?></textarea>
    </fieldset>
    <fieldset>
        <label for="logo" class="col-sm-2">Image: </label>
        <input type="file" name="logo" id="logo"  />
    </fieldset>
    <?php if (!empty($logo)) {
    echo '<div class="col-sm-offset-2">
            <img title="Logo" src="images/' . $logo . '" class="img-circle" />
         </div>';
    }
    ?>
    <input type="hidden" name="page_id" id="page_id" value="<?php echo $page_id; ?>" />
    <input type="hidden" name="current_logo" id="current_logo" value="<?php echo $logo; ?>" />
    <button class="btn btn-primary col-sm-offset-2">Save</button>
</form>

<?php require('footer.php');
ob_flush(); ?>