<?php
/**
 * This is a Tamara pagecontroller.
 *
 
 Include the essential config-file which also creates the $ta variable with its defaults.
*/
include(__DIR__.'/config.php'); 
//include(__DIR__.'/filter.php'); 

// Add style for CDatabase
//$tamara['stylesheets'][] = 'css/table.css';
//$tamara['stylesheets'][] = 'css/forms.css';

// Connect to a MySQL database using PHP PDO
$db = new CDatabase($tamara['database']);
$blog= new CBlog($db); 
$textfilter= new CTextFilter();  

// Get parameters 
$slug    = isset($_GET['slug']) ? $_GET['slug'] : null;
$acronym = isset($_SESSION['user']) ? $_SESSION['user']->acronym : null;


/*Get content
$slugSql = $slug ? 'slug = ?' : '1';
$sql = "
SELECT *
FROM Content
WHERE
  type = 'post' AND
  $slugSql AND
  published <= NOW()
ORDER BY updated DESC
;
";
$res = $db->ExecuteSelectQueryAndFetchAll($sql, array($slug));

*/

// Do it and store it all in variables in the Tamara container.
$tamara['title'] = "Bloggen";
$tamara['debug'] = $db->Dump();

//kan redigera blogg om man är inloggad, annars inte
if(isset($_SESSION['user'])){  
$tamara['main'] = "<div class= 'right'><a href='view.php' > Redigera blogg </a></div>";
}
else
{
$tamara['main'] =null;	
}
$res=$blog->createBlogs(); 
//var_dump(isset($res[0]));
if(isset($res[0])) {
  foreach($res as $c) {
    // Sanitize content before using it.
    $title  = htmlentities($c->title, null, 'UTF-8');
    $data   =$textfilter-> doFilter(htmlentities($c->data, null, 'UTF-8'), $c->filter);
	 $created=htmlentities($c->created, null, 'UTF-8'); 
	//echo"$data";

    if($slug) {
      $tamara['title'] = "$title | " . $tamara['title'];
    }
    $editLink = $acronym ? "<a href='edit.php?id={$c->id}'>
	Uppdatera posten</a>" : null;
	//var_dump($acronym);

$tamara['main'] .= <<<EOD
<section>

  <article>
  <header>
  
  <h1><a href='blog.php?slug={$c->slug}'>{$title}</a></h1>
 
  </header>
{$data}
  <p>Skapad: {$created}</p> 
<footer>
{$editLink}
</footer>
 
  </article>
</section>
EOD;
  }
}

else if($slug) {
  $tamara['main'] = "Det fanns inte en sådan bloggpost.";
}
else {
  $tamara['main'] = "Det fanns inga bloggposter.";
}



// Finally, leave it all to the rendering phase of Tamara.
include(TAMARA_THEME_PATH);
?>


