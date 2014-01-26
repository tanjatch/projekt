<?php 
/**
 * This is a Tamara pagecontroller.
 *
 
 Include the essential config-file which also creates the $ta variable with its defaults.
*/
include(__DIR__.'/config.php'); 


// Define what to include to make the plugin to work
//$tamara['stylesheets'][]        = 'css/slideshow.css';
//$tamara['jquery']               = true;
//$tamara['javascript_include'][] = 'js/slideshow.js';


// Do it and store it all in variables in the Tamara container.
$tamara['title'] = "Om oss";

$tamara['main'] = <<<EOD
<article class= "readable"> 
 <h1>Om oss</h1>
  
  <img  class="right" src="img/film.jpg" width="300" height="200" alt="Bild filmen">
 
  <p> 

Med Rental Movies är din kväll fixad! Här kan du enkelt streama ett stort antal filmer med bra kvalité.</p>

<p> Välj en film, poppa popcornen och njut av det bästa filmvärlden har att erbjuda!.<p> 

   
 
  
{$tamara['byline']}

</article> 
EOD;



// Finally, leave it all to the rendering phase of Tamara.
include(TAMARA_THEME_PATH);