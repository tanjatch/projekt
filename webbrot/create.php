 <?php 
/**
 * This is a Tamara pagecontroller.
 *
 */
// Include the essential config-file which also creates the $embla variable with its defaults.
include(__DIR__.'/config.php'); 


// Connect to a MySQL database using PHP PDO
$db = new CDatabase($tamara['database']);
$content=new CContent($db);




if (isset($_POST['create']))
{
$title  = $_POST['title'];    
$output=$content->create($title);
if ($output==null)
$output="Det fungerade inte!";

}


// Prepare content and store it all in variables in the Embla container.
$tamara['title'] = "Skapa nytt innehåll";
$tamara['debug'] = $db->Dump();

$tamara['main'] = <<<EOD
<h1>{$tamara['title']}</h1>

<form method=post>
  <fieldset>
  <legend>Skapa nytt innehåll</legend>
  <p><label>Titel:<br/><input type='text' name='title'/></label></p>
  <p><input type='submit' name='create' value='Skapa'/></p>
  </fieldset>
</form>

EOD;



// Finally, leave it all to the rendering phase of Embla.
include(TAMARA_THEME_PATH);
