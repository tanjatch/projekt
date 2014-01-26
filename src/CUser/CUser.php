<?php
/**
 * Description of CUser
 *

 */
class CUser {
   /**
   * Properties
   *
   */
  //  private $db;
    /**
    * Constructor
    *
    */
    public function __construct($db) {
     $this->db=$db;
    }
    /**
    * Check if user is authenticated.
    */
    function IsAuthenticated()
    { 
       if(isset($_SESSION['user'])){
            return true;
        }
        else{
            return false;
        }
    }
    /**
    * Gets output.
    */
    function outputIsAuthenticated()
    {
        $acronym = isset($_SESSION['user']) ? $_SESSION['user']->acronym : null;
        if($acronym) {
            $output = "Du är inloggad som: $acronym ({$_SESSION['user']->name})";
        }
        else {
            $output = "Du är INTE inloggad.";
        }
    return $output;
    }
    /**
    * Method to login the user
    */
    function loginUser($user, $password)
	{
			// Connect to a MySQL database using PHP PDO
     //  $db = new CDatabase($this->db);
		
			$sql = "SELECT acronym, name FROM USER WHERE acronym = ? AND password = md5(concat(?, salt))";
            $params = array();
            $params =[htmlentities($user), htmlentities($password)];
			
            $res=$this->db->ExecuteSelectQueryAndFetchAll($sql, $params);
			//dump($res);
            if(isset($res[0])) {
                $_SESSION['user'] = $res[0];
				//dump('hej');
                return true;
            }
            else {
                return false;
			}
    }
    /**
    * Method to logout the user
    */
    function logoutUser()
    {
    // Logout the user
       unset($_SESSION['user']);
     
      
    }
} 