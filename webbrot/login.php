<?php
/**
 * This is a Tamara pagecontroller.
 *
 
 Include the essential config-file which also creates the $ta variable with its defaults.
*/
include(__DIR__.'/config.php'); 

// Add style for CDatabase

$tamara['stylesheets'][] = 'css/forms.css';
$tamara['title'] = "Logga in";
$db = new CDatabase($tamara['database']);
$user= new CUser($db); 

$success=true;
if(!$user->IsAuthenticated()){
    if(isset($_POST['acronym'], $_POST['password'])){
		// var_dump($_POST); 
       $success=$user->loginUser($_POST['acronym'], $_POST['password']);
	    
    }
	
}
if(!$success)
{
    $output = "Du lyckades ej logga in.";

}
else{
    $output=$user->outputIsAuthenticated();
}
$tamara['main'] = <<<EOD
<h1>Logga in</h1>
<form method=post>
  <fieldset>
  <legend>Login</legend>
 <!--- <p><em>Du kan logga in med doe:doe eller admin:admin.</em></p>--!>
  <p><label>Användare:<br/><input type='text' name='acronym' value=''/></label></p>
  <p><label>Lösenord:<br/><input type='text' name='password' value=''/></label></p>
  <p><input type='submit' name='btnLogin' value='Login'/></p>
  <p><a href='logut.php'>Logga ut</a></p> 
 
  <output><b>{$output}</b></output>
  </fieldset>
</form>
EOD;

// Finally, leave it all to the rendering phase of Tamara.
include(TAMARA_THEME_PATH);
?>
 


