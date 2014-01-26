 <?php
class CContent {
    
protected $db;
//private $id;
 /**
   * Constructor
   *
   */
public function __construct($db) {
       
     $this->db=$db;
    }
function restore()
{
    $sql="
    DROP TABLE IF EXISTS Content;
    CREATE TABLE Content
    (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    slug CHAR(80) UNIQUE,
    url CHAR(80) UNIQUE,
    
    type CHAR(80),
    title VARCHAR(80),
    data TEXT,
    filter CHAR(80),
 
    published DATETIME,
    created DATETIME,
    updated DATETIME,
    deleted DATETIME ) ENGINE INNODB CHARACTER SET utf8;
    ";
try
 {
  $this->db->ExecuteQuery($sql);
 }
 catch (Exception $e)
 { 
     $ouput=null;
     
 }
$sql= "INSERT INTO Content (slug, url, type, title, data, filter, published, created) VALUES
    ( 'hem','hem', 'page', 'Hem', 'Detta är min hemsida. Den är skriven i [url=http://en.wikipedia.org/wiki/BBCode]bbcode[/url] vilket innebär att man kan formattera texten till [b]bold[/b] och [i]kursiv stil[/i] samt hantera länkar.\n\nDessutom finns ett filter nl2br som lägger in <br>-element istället för \\n, det är smidigt, man kan skriva texten precis som man tänker sig att den skall visas, med radbrytningar.', 'bbcode,nl2br', NOW(), NOW()),
    ('om', 'om', 'page', 'Om', 'Detta är en sida om mig och min webbplats. Den är skriven i [Markdown](http://en.wikipedia.org/wiki/Markdown). Markdown innebär att du får bra kontroll över innehället i din sida, du kan formattera och sätta rubriker, men du behöver inte bry dig om HTML.\n\nRubrik nivå 2\n-------------\n\nDu skriver enkla styrtecken för att formattera texten som **fetstil** och *kursiv*. Det finns ett speciellt sätt att länka, skapa tabeller och så vidare.\n\n###Rubrik nivå 3\n\nNär man skriver i markdown så blir det lösbart även som textfil och det är lite av tanken med markdown.', 'markdown', NOW(), NOW()),
    ('blogpost-1', NULL, 'post', 'Filmbloggen', 'Välkommen till filmbloggen! Här får du veta det senaste från filmens värld så du vet vilka filmer du ska hålla utkik efter här på Rental Movies. ', 'link,nl2br', NOW(), NOW()),
    ('blogpost-2', NULL, 'post', 'Girl next door – Jennifer Lawrence', 'Förra årets vinnare av en Oscar (för bästa kvinnliga huvudroll) Jennifer Lawrence får bara en allt större troféhylla. Den 23 åriga skådespelerskan vann en Oscar för sin roll i Silver Linings Playbook (sv: Du gör mig galen!) och har också slagit stort i rollen som Katniss i The Hunger Games. I år har Lawrence redan hunnit vinna en Golden Globe för bästa kvinnliga huvudroll för sin roll i American Hustle och hon är återigen nominerad för en Oscar för samma roll! Vad tycker ni om den älskade och talangfulla Lawrence? Hyr Silver Linings Playbook och The Hunger Games så får ni veta vart all Oscar buzz kommer ifrån.', 'nl2br', NOW(), NOW()),
	('blogpost-3', NULL, 'post', 'Äntligen en Oscar för Leo DiCaprio?', 'Efter en lång karriär har Leonardo DiCaprio vunnit många priser men aldrig en Oscar. DiCaprio har varit nominerad fyra gånger tidigare (sist för sin roll i Blood Diamond) och är i år nominerad igen. Men hans konkurrenter är inga amatörer. Bland dem finns Chiwetel Ejifor som är nominerad för sin känslosamma roll i 12 Years a Slave. Tror ni DiCaprio i år äntligen får sin Oscar? Hyr Titanic eller The Great Gatsby för att se mer av DiCaprio nu.', 'nl2br', NOW(), NOW()), 
	('blogpost-4', NULL, 'post', 'American Hustle ', 'Här är en film som verkar veta vad folk gillar. American Hustle har i år vunnit en SAG för \"Outstanding Performance by Cast in a Motion Picture\" och en Golden Globe för \"Best Motion Picture – Musical or Comedy\". Inte nog med det, nu är filmen också nominerad i flera Oscar kategorier.  Mannen bakom filmen är David O. Russell och har tidigare regisserat bland annat de Oscarsvinnande filmerna Silver Linings Playbook och The Fighter. Vad tror ni, vet han vad som gör en Oscarsvinnare? Hyr hans tidigare storfilmer här på Rental Movies.', 'nl2br', NOW(), NOW()),
	('blogpost-5', NULL, 'post', 'Blue Jasmine', 'Woody Allens senaste film Blue Jasmine har satt Cate Blanchet på tapeten i Hollywoods olika filmgalor. Blanchet har i år vunnit en Golden Globe och en SAG för sin roll. Vad tycker ni om Woody Allens tidigare filmer, till exempel Förälskad i Rom och Midnatt i Paris? Hyr dem här på Rental Movies.', 'nl2br', NOW(), NOW()),
	('blogpost-6', NULL, 'post', 'Vägen till Oscars', 'Oscarsnomineringarna har kommit ut!  Vem borde vinna? Vem har de glömt att nominera?', 'nl2br', NOW(), NOW()),
	('blogpost-7', NULL, 'post', 'Scorsese och The Wolf of Wall Street', 'Scorsese har i år slagit stort med filmen The Wolf of Wall Steet med Leonardo DiCaprio i huvudrollen. Filmen har redan vunnit priser och är Oscarsnominerad för bland annat \"Best Motion Picture of the Year\". Vilken är er favorit Scorsese film? Hyr en av hans rullar här på Rental Movies.', 'nl2br', NOW(), NOW());
";    
 try
 {
     
  $this->db->ExecuteQuery($sql);
 }
 catch (Exception $e)
 { 
     $ouput=null;
     
 }
  $output = "Databasen är återställd";
  return $output;
}

function edit()
{
   // Get parameters 
$id    = isset($_POST['id'])    ? strip_tags($_POST['id']) : (isset($_GET['id']) ? strip_tags($_GET['id']) : null);
$title  = isset($_POST['title']) ? $_POST['title'] : null;
$slug   = isset($_POST['slug'])  ? $_POST['slug']  : null;
$url    = isset($_POST['url'])   ? strip_tags($_POST['url']) : null;
$data   = isset($_POST['data'])  ? $_POST['data'] : array();
$type   = isset($_POST['type'])  ? strip_tags($_POST['type']) : array();
$filter = isset($_POST['filter']) ? $_POST['filter'] : array();
$published = isset($_POST['published'])  ? strip_tags($_POST['published']) : array();


$sql = '
    UPDATE Content SET
      title   = ?,
      slug    = ?,
      url     = ?,
      data    = ?,
      type    = ?,
      filter  = ?,
      published = ?,
      updated = NOW()
    WHERE 
      id = ?
  ';
  $params = array($title, $slug, $url, $data, $type, $filter, $published, $id);
  $this->db->ExecuteQuery($sql, $params);
  $output = 'Informationen sparades.';
  return $output;
}
function create($title)
{
  $sql = 'INSERT INTO Content (title) VALUES (?)';
 // $acronym = isset($_SESSION['user']) ? $_SESSION['user']->acronym : null;
  $params = array($title); //,$acronym);
  $this->db->ExecuteQuery($sql,$params);
  header('Location: edit.php?id=' . $this->db->LastInsertId());
}
function delete($id)
{
   $sql = 'DELETE FROM Content WHERE id = ? LIMIT 1';
   $params = array($id);
   $this->db->ExecuteQuery($sql, $params);
   $output="Det raderades " . $this->db->RowCount() . " rader från databasen.";
   return $output;
}
function selectWithId($id)
{
    // Select from database
    $sql = 'SELECT * FROM Content WHERE id = ?';
    $res = $this->db->ExecuteSelectQueryAndFetchAll($sql, array($id));
        if(isset($res[0])) {
            $c = $res[0];
            return $c;
        }
        else {
        die('Misslyckades: det finns inget innehåll med id '.$id);
            return null;
        }
}

function selectPageWithUrl($url)
{
   // Get content
$sql = "
SELECT *
FROM Content
WHERE
  type = 'page' AND
  url = ? AND
  published <= NOW();
";
$res = $this->db->ExecuteSelectQueryAndFetchAll($sql, array($url));

if(isset($res[0])) {
  $c = $res[0];
  return $c;
}
else {
  die('Misslyckades: det finns inget innehåll.');
  return null;
}
}
function selectPostWithSlug($slug)
{
    // Get content
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
    $res = $this->db->ExecuteSelectQueryAndFetchAll($sql, array($slug));
    return $res;
    
    }
} 