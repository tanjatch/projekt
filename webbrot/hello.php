<?php 
/**
 * This is a Tamara pagecontroller.
 *
 */
// Include the essential config-file which also creates the $anax variable with its defaults.
include(__DIR__.'/config.php'); 


// Do it and store it all in variables in the Anax container.
$tamara['title'] = "Hello World";

//$tamara['header'] = <<<EOD
//<img class='sitelogo' src='img/tamara.png' alt='Tamara Logo'/>
//<span class='sitetitle'>Tamara webbtemplate</span>
//<span class='siteslogan'>Återanvändbara moduler för webbutveckling med PHP</span>
//EOD;

$tamara['main'] = <<<EOD
<h1>Hej Världen</h1>
<p>Detta är en exempelsida som visar hur Tamara ser ut och fungerar.</p>
EOD;

//$atamara['footer'] = <<<EOD
//<footer><span class='sitefooter'>Tanja Tchoumak
//EOD;


// Finally, leave it all to the rendering phase of Tamara.
include(TAMARA_THEME_PATH);