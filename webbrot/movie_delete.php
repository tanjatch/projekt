<?php 
/**
 * This is aTAmara pagecontroller.
 *
 */
// Include the essential config-fi
include(__DIR__.'/config.php'); 



// Connect to a MySQL database using PHP PDO
$db = new CDatabase($tamara['database']);
$mov= new CMovie($db);


$id = strip_tags($_GET['id']);
$acronym = isset($_SESSION['user']) ? $_SESSION['user']->acronym : null;

// Check that incoming parameters are valid
isset($acronym) or die('Check: You must login to delete.');
is_numeric($id) or die('Check: Id must be numeric.');

$output="";
if (!isset($_POST['delete']))
{
    $m=$mov->selectMovieWithId($id);
    $title  = htmlentities($m->title, null, 'UTF-8');
}
else
{
    $output=$mov->delete($id);
    $title="";
    if ($output==null)
        $output="Det fungerade inte!";
}

$title="Ta bort ".$title;
// Prepare content and store it all in variables in the Embla container.
$tamara['title'] = $title;
$tamara['main'] = <<<EOD
<article>
<header>
<h1>{$title}</h1>
</header>
<form method=post>
<p><input type='submit' name='delete' value='Ta bort'/></p>
</form>
<p1>{$output}</p1>

<footer>
<p><a href='movies.php'>Visa alla</a></p>
</footer
</article>
EOD;


// Finally, leave it all to the rendering phase of Embla.
include(TAMARA_THEME_PATH); 