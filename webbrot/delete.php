 <?php 
/**
 * This is a TAMARA pagecontroller.
 *
 */

include(__DIR__.'/config.php'); 



// Connect to a MySQL database using PHP PDO
$db = new CDatabase($tamara['database']);
$content= new CContent($db);


$id = strip_tags($_GET['id']);
$acronym = isset($_SESSION['user']) ? $_SESSION['user']->acronym : null;

// Check that incoming parameters are valid
isset($acronym) or die('Check: You must login to delete.');
is_numeric($id) or die('Check: Id must be numeric.');

$output="";
if (!isset($_POST['delete']))
{
    $c=$content->selectWithId($id);
    $title  = htmlentities($c->title, null, 'UTF-8');
}
else
{
    $output=$content->delete($id);
    $title="";
    if ($output==null)
        $output="Det fungerade inte!";
}

$title="Ta bort ".$title;
// Prepare content and store it all in variables in the Me container.
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
<p><a href='view.php'>Visa alla</a></p>
</footer
</article>
EOD;


// Finally, leave it all to the rendering phase of Tamara.
include(TAMARA_THEME_PATH);  