<?php
/**
 * This is a Tamara pagecontroller.
 *
 
 Include the essential config-file which also creates the $ta variable with its defaults.
*/
include(__DIR__.'/config.php'); 

// Add style for CDatabase

$tamara['stylesheets'][] = 'css/forms.css';
$tamara['title'] = "Logout";
$db = new CDatabase($tamara['database']);
$user= new CUser($db);
 
if(isset($_POST['btnLogout'])){
    $user->logoutUser();
}
$output=$user->outputIsAuthenticated(); 
$tamara['main'] = <<<EOD
<h1>Log out</h1>
 <form method=post>
  <fieldset>
  <legend>Logout</legend>
  <p><input type='submit' name='btnLogout' value='Logout'/></p>
 <p><a href='login.php'>Logga in</a></p> 
  <output><b>{$output}</b></output>
  </fieldset>
</form>
EOD;
 
// Finally, leave it all to the rendering phase of Tamara.
include(TAMARA_THEME_PATH);
?>

 

