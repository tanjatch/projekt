<?php
/**
 * This is a Tamara pagecontroller.
 *
 
 Include the essential config-file which also creates the $ta variable with its defaults.
*/
include(__DIR__.'/config.php'); 



// Connect to a MySQL database using PHP PDO
$db = new CDatabase($tamara['database']);
$content=new CContent($db);

// Get parameters 
$id     = isset($_POST['id'])    ? strip_tags($_POST['id']) : (isset($_GET['id']) ? strip_tags($_GET['id']) : null);
$title  = isset($_POST['title']) ? $_POST['title'] : null;
$slug   = isset($_POST['slug'])  ? $_POST['slug']  : null;
$url    = isset($_POST['url'])   ? strip_tags($_POST['url']) : null;
$data   = isset($_POST['data'])  ? $_POST['data'] : array();
$type   = isset($_POST['type'])  ? strip_tags($_POST['type']) : array();
$filter = isset($_POST['filter']) ? $_POST['filter'] : array();
$published = isset($_POST['published'])  ? strip_tags($_POST['published']) : array();
$save   = isset($_POST['save'])  ? true : false;
$acronym = isset($_SESSION['user']) ? $_SESSION['user']->acronym : null;


// Check that incoming parameters are valid
isset($acronym) or die('Check: You must login to edit.');
is_numeric($id) or die('Check: Id must be numeric.');


// Check if form was submitted
$output = null;
if($save) {
	 $output=$content->edit(); 
	 }

$c=$content->selectWithId($id); 

// Sanitize content before using it.
$title  = htmlentities($c->title, null, 'UTF-8');
$slug   = htmlentities($c->slug, null, 'UTF-8');
$url    = htmlentities($c->url, null, 'UTF-8');
$data   = htmlentities($c->data, null, 'UTF-8');
$type   = htmlentities($c->type, null, 'UTF-8');
$filter = htmlentities($c->filter, null, 'UTF-8');
$published = htmlentities($c->published, null, 'UTF-8');

// Do it and store it all in variables in the Tamara container.
$tamara['title'] = "Uppdatera innehållet";
$tamara['debug'] = $db->Dump();


$tamara['main'] = <<<EOD
<h1>{$tamara['title']}</h1>

<form method=post>
  <fieldset>
  <legend>Uppdatera innehåll</legend>
  <input type='hidden' name='id' value='{$id}'/>
  <p><label>Titel:<br/><input type='text' name='title' value='{$title}'/></label></p>
  <p><label>Slug:<br/><input type='text' name='slug' value='{$slug}'/></label></p>
  <p><label>Url:<br/><input type='text' name='url' value='{$url}'/></label></p>
  <p><label>Text:<br/><textarea name='data'>{$data}</textarea></label></p>
  <p><label>Type:<br/><input type='text' name='type' value='{$type}'/></label></p>
  <p><label>Filter:<br/><input type='text' name='filter' value='{$filter}'/></label></p>
  <p><label>Publiseringsdatum:<br/><input type='text' name='published' value='{$published}'/></label></p>
  <p class=buttons><input type='submit' name='save' value='Spara'/> <input type='reset' value='Återställ'/></p>
  <p><a href='view.php'>Visa alla</a></p>
  
  <output>{$output}</output>
  </fieldset>
</form>

EOD;


// Finally, leave it all to the rendering phase of Tamara.
include(TAMARA_THEME_PATH);
?>


