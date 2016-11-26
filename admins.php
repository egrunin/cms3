<?php ob_start();
// auth check 
require('auth.php');
// set title
$page_title = 'Admins';
require('header.php'); ?>

<?php

try {
    // connect
    require('db.php'); 

    // prepare the query
    $sql = "SELECT * FROM admins";
    $cmd = $conn -> prepare($sql);

    // run the query and store the results
    $cmd -> execute();
    $admins = $cmd -> fetchAll();

    // start the grid with HTML
    echo '<table class="table sortable">
            <thead>
                <th><a href="#">Email</a></th>
            </thead>
          <tbody>';

    /* loop through the data, displaying each value in a new column
    and each registrant in a new row */
    foreach($admins as $data) {
        echo '<tr>
                <td>' . $data['email'] . '</td>
              </tr>';
    }

    // close the HTML grid
    echo '</tbody></table>';
}

catch (Exception $e) {
    // send IT Dep. an error email
    mail('jack.grunin@gmail.com', 'CMS ADMIN ERROR', $e);
    
    // redirect to the error page
    header('location:404.php');
}

// disconnect
    $conn = null;
?>
<div class="fb-comments" data-href="http://gc200310426.computerstudi.es/CMSGR/admins.php" data-numposts="3"></div>
<?php require('footer.php');
ob_flush(); ?>
