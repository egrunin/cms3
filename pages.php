<?php ob_start();
// auth check 
require('auth.php');
// set title
$page_title = 'Pages';
require('header.php');
?>
<h1>Pages</h1>
<div>
    <a href="add-page.php">Add Page</a>
</div>
<div clas="col-sm-12 text-right">
    <form method="get" action="pages.php" class="form-inline">
        <label for="keywords">Page Content Keywords:</label>
        <input name="keywords" id="keywords" />
            <select name="search_type" id="search_type">
                <option value="OR">Any Keyword</option>
                <option value="AND">All Keywords</option>
            </select>
        <button class="btn btn-success">Search</button>
    </form>
</div>
<?php
try {
    // connect
    require('db.php'); 

    // prepare the query
    $sql = "SELECT * FROM page";
    
    // check for keyboards, build the WHERe clause dynamically
    if (!empty($_GET['keywords'])) {
        $keywords = $_GET['keywords'];
        
        // convert 1 single keyword value into a list of separate values (array)
        $keyword_list = explode(" ", $keywords);
        
        // start building the where clause 
        $sql .= " WHERE ";
        $counter = 0;
        
        //set the search type AND/OR 
        $search_type = $_GET['search_type'];
        
        // check the word list 
        foreach($keyword_list as $word) {
            
            // add the word OR if we are not on the first keyword
            if ($counter > 0) {
                $sql .= " $search_type ";
            }
            
            // works but breaks with special characters 
            // $sql .= " name LIKE '%" . $word . "%'";
            
            // $sql .= " page_title LIKE ?";
            $sql .= " page_info LIKE ?";
            $keyword_list[$counter] = '%' . $word . '%';
            
            $counter++;
            // echo "$word <br />"; // view that the value is split
        }
    }
    
    // add order by clause 
    // $sql .= " ORDER BY page_title";
    $sql .= " ORDER BY page_info";
    
    // run the query and store the results
    $cmd = $conn -> prepare($sql);
    $cmd -> execute($keyword_list); // pass in the entire word list array
    $page = $cmd -> fetchAll();

    // start the grid with HTML
    echo '<table class="table table-striped sortable"><thead><th><a href="#">Page Title</a></th>
        <th>Edit</th><th>Delete</th></thead><tbody>';

    /* loop through the data, displaying each value in a new column
    and each page in a new row */
    foreach($page as $data) {
        echo '<tr>
                <td>' . $data['page_title'] . '</td>
                <td><a href="add-page.php?page_id=' . $data['page_id'] . '" title="Edit">Edit</a></td>
                <td><a href="page-delete.php?page_id=' . $data['page_id'] . '"
                title="Delete" class="confirmation">Delete</a></td>
            </tr>';
    }

    // close the HTML grid
    echo '</tbody></table>';
}
catch (Exception $e) {
    // send ourselves the error 
    mail('jack.grunin@gmail.com', 'Error', $e);
    header('location:404.php');
}
// disconnect
    $conn = null;
?>

<div class="fb-comments" data-href="http://gc200310426.computerstudi.es/sem2/COMP1006/CMSGR/beers.php" data-numposts="3"></div>

<?php require('footer.php');
ob_flush(); ?>

