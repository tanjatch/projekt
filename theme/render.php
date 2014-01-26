<?php
/**
 * Render content to theme.
 *
 */
 
// Extract the data array to variables for easier access in the template files.
extract($tamara);
 
// Include the template functions-har ändrat from include till include_once.
include_once(__DIR__ . '/functions.php');
 
// Include the template file.
include_once(__DIR__ . '/index.tpl.php');