<?php

/**
 * This is a Tamara pagecontroller.
 * It handles movie information from a database
 */
// Include the essential config-file wh.
include(__DIR__ . '/config.php');

$tamara['stylesheets'][] = 'css/table.css';
$tamara['stylesheets'][] = 'css/form.css';


// Connect to a MySQL database using PHP PDO
$db = new CDatabase($tamara['database']);
$movies=new CMovie($db);
if(isset($_GET["id"]))
{ 
  $id =strip_tags($_GET["id"]);
}
is_numeric($id) or die('Check: Id must be numeric.');

$movie=$movies->selectMovieWithId($id);


$htmledit="";
if(isset($_SESSION['user']))
{
    $htmledit="<a href='movie_edit.php?id={$movie->id}'>editera </a> &nbsp <a href='movie_delete.php?id={$movie->id}'> ta bort</a>";
}
$tamara['title'] = $movie->title;




$tamara['main'] = <<<EOD
<h1>{$tamara['title']}</h1>

 <div><img max-width='400' max-height='300' src="{$movie->image}" alt='Bild' /></div>
<br/>
<article>{$movie->plot}</article>

<p>År {$movie->year}</p>


  <p><a href='movies.php'>Visa alla</a></p>
  
<div>
  <p>{$htmledit}</p>
</div>


EOD;

// Finally, leave it all to the rendering phase of Tamara.
include(TAMARA_THEME_PATH); 