 <?php
class CPage extends CContent{
    

 /**
   * Constructor
   *
   */
public function __construct($db) {
     parent::__construct($db);  
    
    }

function createPage(){

$url     = isset($_GET['url']) ? $_GET['url'] : null;
$c=$this->selectPageWithUrl($url);
return $c;

}

} 