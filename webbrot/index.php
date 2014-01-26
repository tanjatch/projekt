<?php
/**
 * This is a Tamara pagecontroller.
 *
 
 Include the essential config-file which also creates the $ta variable with its defaults.
*/
include(__DIR__.'/config.php'); 

// Add style for CDatabase
$tamara['stylesheets'][] = 'css/table.css';
$tamara['stylesheets'][] = 'css/forms.css';
// Do it and store it all in variables in the Tamara container.
$tamara['title'] = "Första sidan";



// Connect to a MySQL database using PHP PDO
$db = new CDatabase($tamara['database']);
$movie = new CMovie($db);

//for blogg
$blog= new CBlog($db); 
$textfilter= new CTextFilter();


//for kategoris
$res=$movie->selectCategories();
$cat="";
foreach ($res as $category) {
    $cat.="$category->name \t";
    
}   

// Get parameters 
$title    = isset($_GET['title']) ? $_GET['title'] : null;
$genre    = isset($_GET['genre']) ? $_GET['genre'] : null;
$hits     = isset($_GET['hits'])  ? $_GET['hits']  : 8;
$page     = isset($_GET['page'])  ? $_GET['page']  : 1;
$year1    = isset($_GET['year1']) && !empty($_GET['year1']) ? $_GET['year1'] : null;
$year2    = isset($_GET['year2']) && !empty($_GET['year2']) ? $_GET['year2'] : null;
$orderby  = isset($_GET['orderby']) ? strtolower($_GET['orderby']) : 'id';
$order    = isset($_GET['order'])   ? strtolower($_GET['order'])   : 'asc';


// Check that incoming parameters are valid
is_numeric($hits) or die('Check: Hits must be numeric.');
is_numeric($page) or die('Check: Page must be numeric.');
is_numeric($year1) || !isset($year1)  or die('Check: Year must be numeric or not set.');
is_numeric($year2) || !isset($year2)  or die('Check: Year must be numeric or not set.');



//select only 3 films from database
$sql = "SELECT * from rentalmovie ORDER BY id DESC LIMIT 3;";
$res = $db->ExecuteSelectQueryAndFetchAll($sql); 

//select only tre bloggs from database
 $sql='SELECT * FROM content
  WHERE type = "post"
    ORDER BY published DESC
    LIMIT 3';
    $ress = $db->ExecuteSelectQueryAndFetchAll($sql, array()); 

$items="";
foreach ($ress as $blog) {
    // latestpost id 
     $data   = $textfilter->doFilter(htmlentities($blog->data, null, 'UTF-8'), $blog->filter); 
$items.="<div><a href='blog.php?slug={$blog->slug}'>{$blog->title}</a>
        <p>{$data}</p></div>";
    
}





// Put results into a HTML-table
$tr = "  ";
foreach($res AS $key => $val) {
  $tr .= "<tr><td><img width='100' height='80' src='{$val->image}' alt='{$val->title}' /></td><td>{$val->title}</td><td>{$val->year}</td></tr>";
}





$tamara['main'] = <<<EOD
<h1>Tre senaste filmer</h1>
<div class='dbtable'>
  
  <table>
  {$tr}
  </table>
 
</div>
<h2>Vi har kategorier:</h2> 
<p> {$cat}</p>



<h1>Tre senaste blogg inlägg</h1>

 <p> {$items}</p>


EOD;


	 



// Finally, leave it all to the rendering phase of Tamara.
include(TAMARA_THEME_PATH);
?>

