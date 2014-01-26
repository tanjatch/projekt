 <?php 
/**
 * This is a Tamara, pagecontroller.
 *
 */
// Include the essential config-file w.
include(__DIR__.'/config.php'); 
$tamara['stylesheets'][] = 'css/forms.css';

// Connect to a MySQL database using PHP PDO
$db = new CDatabase($tamara['database']);
$movie=new CMovie($db);

// Get parameters 
$id     = isset($_POST['id'])    ? strip_tags($_POST['id']) : (isset($_GET['id']) ? strip_tags($_GET['id']) : null);
$title  = isset($_POST['title']) ? $_POST['title'] : null;
$director   = isset($_POST['director'])  ? $_POST['director']  : null;
$year    = isset($_POST['year'])   ? strip_tags($_POST['year']) : null;
$plot   = isset($_POST['plot'])  ? $_POST['plot'] : array();
$image   = isset($_POST['image'])  ? strip_tags($_POST['image']) : array();
$prise = isset($_POST['prise']) ? $_POST['prise'] : array();

$save   = isset($_POST['save'])  ? true : false;
$acronym = isset($_SESSION['user']) ? $_SESSION['user']->acronym : null;


// Check that incoming parameters are valid
isset($acronym) or die('Check: You must login to edit.');
is_numeric($id) or die('Check: Id must be numeric.');
$m=$movie->selectMovieWithId($id);





// Sanitize content before using it.
$title  = htmlentities($m->title, null, 'UTF-8');
$director   = htmlentities($m->director, null, 'UTF-8');
$plot    =htmlentities($m->plot, null, 'UTF-8');
$image   = htmlentities($m->image, null, 'UTF-8');

$prise   =htmlentities($m->prise, null, 'UTF-8');
$year   =htmlentities($m->year, null, 'UTF-8');

 
$res=$movie->selectCategories();

//$categori="";

$select = "<select id='input1' name='object';'>";
/*$select .= "<option value='-1'>{$m->categori}</option>";

$current=$m->categori;
*/

foreach($res as $object) {
  $selected = "";
  if(isset($_POST['object']) && $_POST['object'] == $object->id) {
    $selected = "selected";
    $current = $object->name;
  }
  $select .= "<option value='{$object->id}' {$selected}>{$object->name}</option>";
}
$select .= "</select>";
$output = null;

// Check if form was submitted
$output = null;
if($save) {
  $output=$movie->edit($current);
  header('Location: movies.php');
}
// Prepare content and store it all.
$tamara['title'] = "Uppdatera film";
$tamara['debug'] = $db->Dump();

$tamara['main'] = <<<EOD
<h1>{$tamara['title']}</h1>

<form method=post>
  <fieldset>
  <legend>Uppdatera film</legend>
  <input type='hidden' name='id' value='{$id}'/>
  <p><label>Titel:<br/><input type='text' name='title' value='{$title}'/></label></p>
  <p><label>Pris:<br/><input type='text' name='prise' value='{$prise}'/></label></p>
  <p><label>Regissör:<br/><input type='text' name='director' value='{$director}'/></label></p>
  <p><label>Handling:<br/><textarea name='plot'>{$plot}</textarea></label></p>
  <p><label>År:<br/><input type='text' name='year' value='{$year}'/></label></p>
  <p><label>Bild:<br/><input type='text' name='image' value='{$image}'/></label></p>
  
  {$select}
  <p class=buttons><input type='submit' name='save' value='Spara'/> <input type='reset' value='Återställ'/></p>
  <p><a href='movies.php'>Visa alla</a></p>
  <output>{$output}</output>
  </fieldset>
</form>

EOD;



// Finally, leave it all to the rendering phas.
include(TAMARA_THEME_PATH);
