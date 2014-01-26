<?php
/**
 * Config-file for Tamara. Change settings here to affect installation.
 *
 */
 
/**
 * Set the error reporting.
 *
 */
error_reporting(-1);              // Report all type of errors
ini_set('display_errors', 1);     // Display all errors 
ini_set('output_buffering', 0);   // Do not buffer outputs, write directly
 

/**
 * Define Tamara paths.
 *
 */
define('TAMARA_INSTALL_PATH', __DIR__ . '/../'); 
/*../Tamara');*/
define('TAMARA_THEME_PATH', TAMARA_INSTALL_PATH . '/theme/render.php');
 
 
/**
 * Include bootstrapping functions.
 *
 */
include(TAMARA_INSTALL_PATH . '/src/bootstrap.php');


/**
 * Start the session.
 *
 */

session_name(preg_replace('/[:\.\/-_]/', '', __DIR__)); 
session_start();  

// Define some constant values, append slash
define('IMG_PATH', __DIR__ .  '/img/');
define('CACHE_PATH', __DIR__ . '/cache/');

define('GALLERY_PATH', __DIR__ . '/img/gallery');
define('GALLERY_BASEURL', 'gallery/'); 
 

 
 
/**
 * Create the Tamara variable.
 *
 */
$tamara = array();
 
 
/**
 * Site wide settings.
 *
 */
$tamara['lang']         = 'sv';
$tamara['title_append'] = ' | RM Rental Movies';/**
/** Theme related settings.
 */
 // Connect to a MySQL database using PHP PDO

$tamara['stylesheet'] = 'css/style.css';

$tamara['stylesheets'] = array('css/style.css');
$tamara['favicon']    = 'favicon.ico';

$tamara['header'] = <<<EOD
 <link href='http://fonts.googleapis.com/?family=Copperplate' rel='stylesheet' />
<img class='sitelogo' src='img/logga.jpg' alt='RM Logo'/>
<span class='sitetitle'>RM Rental Movies</span>
<span class='siteslogan'>Kvällen är fixad!</span>

EOD;

$tamara['footer'] = <<<EOD
<footer><span class='sitefooter'>Copyright (c) RM - Rental Movies</span> <a href='source.php'>   Källkod</a> |
<a href='http://validator.w3.org/unicorn/check?ucn_uri=referer&amp;ucn_task=conformance'>Unicorn</a> |<a href='https://github.com/tanjatch/Tamara-base'>RM på GitHub</a></footer>
EOD;

$tamara['byline'] = <<<EOD
<footer class="byline">
  <figure class="right"><img src="img/film2.jpg" alt="film" height="50"></figure>
  <p> hemsidan om uthyrning</p>
</footer>
EOD;

/**
 * Settings for the database.
 Database settings.


$tamara['database']['dsn']            = 'mysql:host=blu-ray.student.bth.se;dbname=tatc12;';  
$tamara['database']['username']       = 'tatc12';
$tamara['database']['password']       = 'C37:t1#A'; 
$tamara['database']['driver_options'] = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"); 
/**/
$tamara['database']['dsn']            = 'mysql:host=localhost;dbname=Test;';
$tamara['database']['username']       = 'tanja';
$tamara['database']['password']       = '';
$tamara['database']['driver_options'] = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'");

/*
 * The navbar
 *
*/
$tamara['navbar'] = array(
  'class' => 'nb-plain',
  'items' => array(
  	'start'         => array('text'=>'Start  ',         'url'=>'index.php',          'title' => 'Start'),
    'hem'         => array('text'=>'Om oss  ',         'url'=>'me.php',          'title' => 'Presentation om oss'),
    'tävling' => array('text'=>'Tävling', 'url'=>'dice.php', 'title' => 'tävling'),
	'movies' => array('text'=>'Filmer', 'url'=>'movies.php', 'title' => 'Filmer'),
	'sök' => array('text'=>'Sök film', 'url'=>'findmovie.php', 'title' => 'Sök film'),
	'bloggen'=> array('text'=>'Bloggen', 'url'=>'blog.php', 'title' => 'Bloggen'),
	'login' => array('text'=>'Administrera', 'url'=>'login.php','title' => 'login'),
  
 /* 'gallery' => array('text'=>'Gallery', 'url'=>'gallery.php','title' => 'gallery'),*/

  ),
  
  'callback_selected' => function($url) {
    if(basename($_SERVER['SCRIPT_FILENAME']) == $url) {           
      return $url;
    }
  }
);
//sök funktion
$tamara['navsearch'] = <<<EOD
<div class='navsearch'>

<form class='left' method='get' action='movies.php'>
<input type=hidden name=page value='1'/>
    <label><input style='color:#777;' type='search' name='title' value='sök'/></label>
</form>
</div> 
EOD;
/**
 * Settings for JavaScript.
 *
 */
$tamara['modernizr'] = 'js/modernizr.js';
/*
Setting for JavaScript
*/
$tamara['jquery'] = '//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js';

//$tamara['jquery'] = null; // To disable jQuery

$tamara['javascript_include'] = array();
//$tamara['javascript_include'] = array('js/main.js'); // To add extra javascript files
//Add directly in sidecontroller 
/*

$tamara['javascript_include'][] = 'js/main.js';
$tamara['javascript_include'][] = 'js/other.js';
*/

/**
 * Google analytics.
 *
 */
$tamara['google_analytics'] = 'UA-22093351-1'; // Set to null to disable google analytics  