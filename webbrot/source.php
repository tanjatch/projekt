 <?php 
/**
 * This is a Anax pagecontroller.
 *
 */
// Include the essential config-file which also creates the $anax variable with its defaults.
include(__DIR__.'/config.php'); 


// Add style for csource
$tamara['stylesheets'][] = 'css/source.css';


// Create the object to display sourcecode
//$source = new CSource();
//för att se hela webbmallen
$source = new CSource(array('secure_dir' => '..', 'base_dir' => '..'));

// Do it and store it all in variables in the Anax container.
$tamara['title'] = "Visa källkod";

$tamara['main'] = "<h1>Visa källkod</h1>\n" . $source->View();


// Finally, leave it all to the rendering phase of Anax.
include(TAMARA_THEME_PATH);