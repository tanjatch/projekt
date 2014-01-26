 <?php

class CDebug {
        public function __construct() { 
        ; 
    } 

    public function Verbose($message) 
    { 
        echo "<p>" . htmlentities($message) . "</p>"; 
    } 
     
    public function ErrorMessage($message, $header=null) 
    { 
        if(!is_null($header)) 
        { 
            header($header); 
        } 
        die('img.php says: - ' . htmlentities($message) . ' header: ' . htmlentities($header)); 
    } 

} 