 <?php

/**
 * Database wrapper, provides a database API for the framework but hides details of implementation.
 *
 */
class CDatabase {
 
  /**
   * Members
   */
  private $options;                   // Options used when creating the PDO object
  private $db   = null;               // The PDO object
  private $stmt = null;               // The latest statement used to execute a query
  private static $numQueries = 0;     // Count all queries made
  private static $queries = array();  // Save all queries for debugging purpose
  private static $params = array();   // Save all parameters for debugging purpose
 
  /**
   * Constructor creating a PDO object connecting to a choosen database.
   *
   * @param array $options containing details for connecting to the database.
   *
   */
  public function __construct($options) {
    $default = array(
      'dsn' => null,
      'username' => null,
      'password' => null,
      'driver_options' => null,
      'fetch_style' => PDO::FETCH_OBJ,
            // Get debug information from session if any.
    );
    $this->options = array_merge($default, $options);
 
    $this->db = new PDO($this->options['dsn'], $this->options['username'], $this->options['password'], $this->options['driver_options']);
    $this->db->SetAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, $this->options['fetch_style']); 
        // Get debug information from session if any.
    if(isset($_SESSION['CDatabase'])) {
      self::$numQueries = $_SESSION['CDatabase']['numQueries'];
      self::$queries    = $_SESSION['CDatabase']['queries'];
      self::$params     = $_SESSION['CDatabase']['params'];
      unset($_SESSION['CDatabase']);
    }
   
  }
  /**
   * Getters
   */
  public function GetNumQueries() { return self::$numQueries; }
  public function GetQueries() { return self::$queries; }

     /**
   * Execute a select-query with arguments and return the resultset.
   * 
   * @param string $query the SQL query with ?.
   * @param array $params array which contains the argument to replace ?.
   * @param boolean $debug defaults to false, set to true to print out the sql query before executing it.
   * @return array with resultset.
   */
  public function ExecuteSelectQueryAndFetchAll($query, $params=array(), $debug=false) {
 //Make the query
    $this->stmt = $this->db->prepare($query);
    $this->stmt->execute($params);
    $res= $this->stmt->fetchAll();
	
 //log details on the query
 	$rows=count($res);
	 $logQuery = $query . "\n\nResultset has $rows rows.";
    self::$queries[] = $logQuery; 
    self::$params[]  = $params; 
    self::$numQueries++;
 
    if($debug) {
      echo "<p>Query = <br/><pre>{$logQuery}</pre></p><p>Num query = " . self::$numQueries . "</p><p><pre>".print_r($params, 1)."</pre></p>";
    }
 return $res;
  }

    /**
   * Execute a SQL-query and ignore the resultset.
   *
   * @param string $query the SQL query with ?.
   * @param array $params array which contains the argument to replace ?.
   * @param boolean $debug defaults to false, set to true to print out the sql query before executing it.
   * @return boolean returns TRUE on success or FALSE on failure. 
 	*/
  public function ExecuteQuery($query, $params = array(), $debug=false) {
	  self::$queries[] = $query; 
    self::$params[]  = $params; 
    self::$numQueries++;
 /*make the query
 $this->stmt = $this->db->prepare($query);
    $res=$this->stmt->execute($params);
	
	// Log details on the query
    $error = $res ? null : "\n\nError in executing query: " . $this->ErrorCode() . " " . print_r($this->ErrorInfo(), 1);
    $logQuery = $query . $error;
    self::$queries[] = $logQuery; 
    self::$params[]  = $params; 
    self::$numQueries++;

    // Debug if set
	*/
    if($debug) {
		 echo "<p>Query = <br/><pre>{$query}</pre></p><p>Num query = " . self::$numQueries . "</p><p><pre>".print_r($params, 1)."</pre></p>"; 
		/*
      echo "<p>Query = <br/><pre>".htmlentities($logQuery)."</pre></p><p>Num query = " . self::$numQueries . "</p><p><pre>".htmlentities(print_r($params, 1))."</pre></p>";
	  */
	  
    }
 $this->stmt = $this->db->prepare($query);
    $res=$this->stmt->execute($params);
  
    return $res;
  }  
    /**
   * Return last insert id.
   */
  /**
   * Return last insert id.
   */
  public function LastInsertId() {
    return $this->db->lastInsertid();
  }  
   /**
   * Return rows affected of last INSERT, UPDATE, DELETE
   */
  public function RowCount() {
    return is_null($this->stmt) ? $this->stmt : $this->stmt->rowCount();
  }
  
    /**
   * Save debug information in session, useful as a flashmemory when redirecting to another page.
   * 
   * @param string $debug enables to save some extra debug information.
   */
  public function SaveDebug($debug=null) {
    if($debug) {
      self::$queries[] = $debug;
      self::$params[] = null;
    }
 
    self::$queries[] = 'Saved debuginformation to session.';
    self::$params[] = null;
 
    $_SESSION['CDatabase']['numQueries'] = self::$numQueries;
    $_SESSION['CDatabase']['queries']    = self::$queries;
    $_SESSION['CDatabase']['params']     = self::$params;
  }
   /**
   * Get a html representation of all queries made, for debugging and analysing purpose.
   *
   * @return string with html.
   */
  public function Dump() {
    $html  = '<p><i>You have made ' . self::$numQueries . ' database queries.</i></p><pre>';
    foreach(self::$queries as $key => $val) {
      $params = empty(self::$params[$key]) ? null : htmlentities(print_r(self::$params[$key], 1), null, 'UTF-8') . '<br/><br/>';
      $html .= htmlentities($val, null, 'UTF-8') . '<br/><br/>' . htmlentities($params, null, 'UTF-8');
    }
	//var_dump($html);
	// return $html . '</pre>'; 
  }
  
  /**
   * Return error code of last unsuccessful statement, see PDO::errorCode().
   *
   * @return mixed null or the error code.
   */
  public function ErrorCode() {
    return $this->stmt->errorCode();
  }



  /**
   * Return textual representation of last error, see PDO::errorInfo().
   *
   * @return array with information on the error.
   */
  public function ErrorInfo() {
    return $this->stmt->errorInfo();
  }

   
} 