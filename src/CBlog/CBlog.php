 <?php

class CBlog extends CContent{
    


 /**
   * Constructor
   *
   */
public function __construct($db) {
     parent::__construct($db);  
    
    }

function createBlogs(){
    // Get parameters 
$slug    = isset($_GET['slug']) ? $_GET['slug'] : null;
$res=$this->selectPostWithSlug($slug);

return $res;

}
}  