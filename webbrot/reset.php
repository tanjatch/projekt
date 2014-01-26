 <?php 
/**
 * This is a Tamara pagecontroller.
 *
 */
// Include the essential config-file which also creates the $tamara variable with its defaults.
include(__DIR__.'/config.php'); 



// Connect to a MySQL database using PHP PDO
$db = new CDatabase($tamara['database']);
$content= new CContent($db);

$output="";
if (isset($_GET['submit']))
{
$outputt=$content->restore();
if ($outputt==null)
$output="Det fungerade inte!";      
}


// Prepare content and store it all in variables in the Tamara container.
$tamara['title'] = "Återställ databasen";
$tamara['main'] = <<<EOD
<article>
<header>
<h1>{$tamara['title']}</h1>
</header>
<form>
<p><input type='submit' name='submit' value='Återställ'/></p>
</form>
<p>{$output}</p>

<footer>
<p><a href='view.php'>Visa alla</a></p>
</footer
</article>
EOD;


// Finally, leave it all to the rendering phase of Tamara.
include(TAMARA_THEME_PATH);  