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
// Do it and store it all in variables in the Tamara container





// Connect to a MySQL database using PHP PDO
$db = new CDatabase($tamara['database']);
$movie = new CMovie($db);

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
$tamara['title'] = "Filmer";

// Get all genres that are active
$sql = '
  SELECT DISTINCT G.name
  FROM Genre AS G
    INNER JOIN Movie3Genre AS M2G
      ON G.id = M2G.idGenre
';
$res = $db->ExecuteSelectQueryAndFetchAll($sql);
//dump($res);

$genres = null;
foreach($res as $val) {
  if($val->name == $genre) {
    $genres .= "$val->name ";
  }
  else {
    $genres .= "<a href='" . $movie->getQueryString(array('genre' => $val->name)) . "'>{$val->name}</a> ";
  }
}

// Prepare the query based on incoming arguments
$sqlOrig = '
  SELECT 
    M.*,
    GROUP_CONCAT(G.name) AS genre
  FROM rentalmovie AS M
    LEFT OUTER JOIN movie3genre AS M2G
      ON M.id = M2G.idMovie
    INNER JOIN Genre AS G
      ON M2G.idGenre = G.id
';
$where    = null;
$groupby  = ' GROUP BY M.id';
$limit    = null;
$sort     = " ORDER BY $orderby $order";
$params   = array();

// Do SELECT from a table
if($title) {
  $where .= ' AND title LIKE ?'; 
  $params[] = $title;  
} 

// Select by year
if($year1) {
  $where .= ' AND year >= ?';
  $params[] = $year1;
} 
if($year2) {
  $where .= ' AND year <= ?';
  $params[] = $year2;
} 

// Select by genre
if($genre) {
  $where .= ' AND G.name = ?';
  $params[] = $genre;
} 

// Pagination
if($hits && $page) {
  $limit = " LIMIT $hits OFFSET " . (($page - 1) * $hits);
}

// Complete the sql statement
$where = $where ? " WHERE 1 {$where}" : null;
$sql = $sqlOrig . $where . $groupby . $sort . $limit;
$res = $db->ExecuteSelectQueryAndFetchAll($sql, $params);



//uppdatera filmerna
$trcreate="";
$htmlcreate="";
$htmledit="";
if(isset($_SESSION['user']))
{
    $htmlcreate="<a href='movie_create.php'>Ny film </a>";
	  $trcreate="</th><th></th><th></th>";
} 




// Put results into a HTML-table
$tr = "<tr><th>Id " . $movie->orderby('id') . "</th><th>Bild</th><th>Titel " . $movie->orderby('title') . "</th><th>År " . $movie->orderby('year') . "</th><th>Genre</th><th>Pris " . $movie->orderby('prise') . "</th>{$trcreate}</tr>";

foreach($res AS $key => $val) {
	if(isset($_SESSION['user']))
{
    $htmledit="<td><a href='movie_edit.php?id={$val->id}'>editera </a></td><td><a href='movie_delete.php?id={$val->id}'> ta bort</a></td>";
} 
  $tr .= "<tr><td>{$val->id}</td><td><img width='80' height='40' src='{$val->image}' alt='{$val->title}' /></td><td><a href='movie_single.php?id={$val->id}'> {$val->title}</td><td>{$val->year}</td><td>{$val->genre}</td><td>{$val->prise}</td>{$htmledit}</tr>";
}



// Get max pages for current query, for navigation
$sql = "
  SELECT
    COUNT(id) AS rows
  FROM 
  (
    $sqlOrig $where $groupby
  ) AS rentalmovie
";
$res = $db->ExecuteSelectQueryAndFetchAll($sql, $params);
$rows = $res[0]->rows;
$max = ceil($rows / $hits);

$hitsPerPage = $movie-> getHitsPerPage(array(2, 4, 8), $hits);
$navigatePage = $movie->getPageNavigation($hits, $page, $max);
$sqlDebug = $db->Dump();



$tamara['main'] = <<<EOD
<h1>Uthyrningslista för filmer</h1>



<div class='dbtable'>
  <div class='rows'>{$rows} träffar. {$hitsPerPage}</div>
  <table>
  {$tr}
  </table>
  <div class='pages'>{$navigatePage}</div>
</div>

<div class=debug>{$sqlDebug}</div>
<p>$htmlcreate</p> 
EOD;


	 



// Finally, leave it all to the rendering phase of Tamara.
include(TAMARA_THEME_PATH);
?>

