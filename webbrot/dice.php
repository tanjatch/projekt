<?php
/**
 * This is a Tamara pagecontroller.
 *
 
 Include the essential config-file which also creates the $ta variable with its defaults.
*/
include(__DIR__.'/config.php'); 
//spara undan text för att visa sedan den i main.
$message="";
// Add style for CImageDice
$tamara['stylesheets'][] = 'css/dice.css';
// Do it and store it all in variables in the Tamara container.
$tamara['title'] = "Tävling";




// Get the arguments from the query string
$roll = isset($_GET['roll']) ? true : false;
$init = isset($_GET['init']) ? true : false;
$save = isset($_GET['save']) ? true : false;
$gameigen=isset($_GET['gameigen']) ? true : false;

// Create the object or get it from the session
//om gameigen är true får vi börja om
if(isset($_SESSION['dicehand'])&& $gameigen==false) {
 // echo "<i>Objektet finns redan i sessionen</i>";
  $hand = $_SESSION['dicehand'];
}
else {
 // echo "<i>Objektet finns inte i sessionen, skapar nytt objekt och lagrar det i sessionen</i>";
  $hand = new CDiceHand(1);
  $_SESSION['dicehand'] = $hand;
}

// Roll the dices 
if($roll) {
  $hand->Roll();
 
}
else if($init) {
  $hand->InitRound();
 $hand->GetAntalplus1();
}
else if($gameigen)
{
	 $_SESSION = array();
	 $message.='Du börjar om';
	
}


$message.='<p>'.$hand->GetRollsAsImageList();
 

if($roll) 
{
$message.='<p>Summan av detta kast blev '.$hand->GetTotal().'.</p>';
if($hand->GetTotal()==1)
  $message.='Du fick en etta. Poängen nollställs.';
}

$message.='Summan i denna spelrundan är '.$hand->GetRoundTotal();
$message.='<p>Summan hittills är  '.$hand->GetSave().'</p>';
if($hand->GetSave()>=100)
{
	$message.= '<h1>Grattis! Du sparade ihop minst 100 poäng.</h1>';
	$message.= 'Du behövde spara  '.$hand->GetAntalplus1().' gånger';
	//tänkte att det var bra att man inte sparar för många gånger, det är min modifikation av spelet.
	if($hand->GetAntalplus1()<=10)
	$message.= '<p>Du klarade det på minde 10 sparomgångar. Bra jobbat! Du vinner tävlingen. </p>';
	else
	$message.= '<p>Kan du klara det på mindre sparomgångar nästa gång?</p> ';
	// för att börja om
	 $_SESSION = array();
}
$tamara['main'] = <<<EOD
<article class= "readable"> 

<h1>RM movie tävling-Tärningsspel 100</h1>

<p> Tärningsspelet 100 är ett enkelt, men roligt. Det gäller att samla ihop poäng för att komma först till 100. I varje omgång kastar du en tärning tills du väljer att stanna och spara poängen eller tills det dyker upp en 1:a och du förlorar alla poäng som samlats in i rundan. Kan du klara det på högst 10 sparomgångar? </p>
<p>Klarar du spelet får du hyra en film gratis. Lycka till!</p>

<p><a href='?init'>Spara poängen hittils </a>.</p> 

<p><a href='?roll'>Gör ett nytt kast</a>.</p>
<p><a href='?gameigen'>Nytt spel</a>.</p>

{$message}
</article>
EOD;


	 



// Finally, leave it all to the rendering phase of Tamara.
include(TAMARA_THEME_PATH);
?>

