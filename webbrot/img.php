<?php
/*****
 *    A Tamara page controller.
 *
 */

include(__DIR__.'/config.php');
/*include('../../kmom06/src/CImage/CImage.php');
define('IMG_PATH', __DIR__ . '/img/');
define('CACHE_PATH', __DIR__ . '/cache/'); 
*/
$image = new CImage();

// Ensure error reporting is on
//
error_reporting(-1);              // Report all type of errors
ini_set('display_errors', 1);     // Display all errors 
ini_set('output_buffering', 0);   // Do not buffer outputs, write directly

$output= null;
//$output= "hej";



$tamara['title'] = "Bilder";


$tamara['main'] = <<<EOD
{$output}
EOD;
 
// Render tamara
include(TAMARA_THEME_PATH); 