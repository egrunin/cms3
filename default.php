<?php ob_start();
// set title and header
$page_title = 'CMS | Public';
require('header.php');
//connect
require('db.php');
?>
<?php
// select and loop through the titles for nav
$sql = "SELECT * FROM page";
$cmd = $conn->prepare($sql);
$cmd->execute();
$page_titles = $cmd->fetchAll();
?>

<div class="col-md-3">
    <ul class="nav nav-pills nav-stacked">
        <?php
        // populate the nav from database
        foreach ($page_titles as $data) {
            echo '<li><a href="default.php?page_id=' . $data["page_id"] . '">' . $data["page_title"] . '</a></li>';
        }
        ?>
    </ul>
</div>

<?php
// check for page id
if ((!empty($_GET['page_id'])) && (is_numeric($_GET['page_id']))) {

    $page_id = $_GET['page_id'];
    // fetch the data for the database
    $sql = "SELECT * FROM page WHERE page_id = :page_id";
    $cmd = $conn->prepare($sql);
    $cmd->bindParam(':page_id', $page_id, PDO::PARAM_INT);
    $cmd->execute();
    $page = $cmd->fetchAll();
    //disconnect
    $conn = null;
    //store each value from the database into a variable
    foreach ($page as $data) {
      $page_title = $data['page_title'];
      $page_info = $data['page_info'];
      $logo = $data['logo'];
    }
  }

?>
<div class="col-md-8">
    <h1><?php echo $page_title ?></h1>
    <p><?php echo $page_info ?></p>
    <p><?php if (!empty($logo)) {
    echo '<div class="col-sm-offset-1">
            <img title="Logo" src="images/' . $logo . '" class="img-circl" />
         </div>';
    }
    ?></p>
</div>

<?php require('footer.php');
ob_flush(); ?>