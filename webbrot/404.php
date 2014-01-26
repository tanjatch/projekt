<?php 
/**
 * This is a Tamara pagecontroller.
 *
 */
// Include the essential config-file which also creates the $anax variable with its defaults.
include(__DIR__.'/config.php'); 
 
 
// Do it and store it all in variables in the Anax container.
$tamara['title'] = "404";
$tamara['header'] = "";
$tamara['main'] = "This is a Anax 404. Document is not here.";
$tamara['footer'] = "";
 
// Send the 404 header 
header("HTTP/1.0 404 Not Found");
 
 
// Finally, leave it all to the rendering phase of Anax.
include(TAMARA_THEME_PATH);
