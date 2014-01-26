 <?php 
/**
 * This is a Tamara pagecontroller.
 *
 */
// Include the essential config-file.
include(__DIR__.'/config.php'); 


// Connect to a MySQL database using PHP PDO
$db = new CDatabase($tamara['database']);
$movie=new CMovie($db);




if (isset($_POST['create']))
{
$title  = $_POST['title'];    
$output=$movie->create($title);
if ($output==null)
$output="Det fungerade inte!";

}


// Prepare content and store it all .
$tamara['title'] = "Skapa ny film";
$tamara['debug'] = $db->Dump();

$tamara['main'] = <<<EOD
<h1>{$tamara['title']}</h1>

<form method=post>
  <fieldset>
  <legend>Skapa ny film</legend>
  <p><label>Titel:<br/><input type='text' name='title'/></label></p>
  <p><input type='submit' name='create' value='Skapa'/></p>
  </fieldset>
</form>

EOD;



// Finally, leave it all to the rendering phase .
include(TAMARA_THEME_PATH);
