<?php 
/**
 * This is aTamara pagecontroller.
 *
 */
// Include the essential config-file which also creates the $tamare variable with its defaults.
include(__DIR__.'/config.php');



$tamara['stylesheets'][] = 'css/figure.css'; 
$tamara['stylesheets'][] = 'css/gallery.css'; 
$tamara['stylesheets'][] = 'css/breadcrumb.css'; 


//$validImages = array('jpeg', 'jpg', 'png', 'gif');
$gallery = new CGallery(); 
//
/* Define the basedir for the gallery
define('GALLERY_PATH', __DIR__ . '/img');
define('GALLERY_BASEURL', '');
*/

//
// Get incoming parameters
//
$path = isset($_GET['path']) ? $_GET['path'] : null;

$pathToGallery = realpath(GALLERY_PATH . '/' . $path);
//var_dump(GALLERY_PATH . '/' . $path);


//
// Prepare content and store it all in variables in the tamara container.

$html = $gallery->ShowGallery($pathToGallery);
$breadcrumb = $gallery->createBreadcrumb($pathToGallery);

$tamara['title'] = "galleri";
$tamara['main'] = <<<EOD
<h1>{$tamara['title']}</h1>

$breadcrumb

$html

EOD;

// Finally, leave it all to the rendering phase of tamara.
include(TAMARA_THEME_PATH); 