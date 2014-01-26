<?php
/**
 * A CDice class to play around with a dice.
 *
 */
class CDice {
 
  /**
   * Properties
   *
   */
  protected $rolls = array();
  private $faces;

  private $last;

 /**
   * Constructor
  
   */
   public function __construct($faces=6) {
    $this->faces = $faces;
  }



  /**
   * Destructor
   *
   */
  public function __destruct() {
    // echo __METHOD__;
  }
 /**
   * Get the rolls as an array.
   *
   */
  public function GetRollsAsArray() {
    return $this->rolls;
  }
  
   /**
   * Get the last rolled value.
   *
   */
  public function GetLastRoll() {
    return $this->last;
  }

  /**
   * Roll the dice
   *
   */
  public function Roll($times) {
 
    for($i = 0; $i < $times; $i++) {
      $this->last = rand(1, $this->faces);
      $this->rolls[] = $this->last;
    }
    return $this->last;
  }
  
  
  public function GetTotal() {
    return array_sum($this->rolls);
  }
  /**
   * Get the average from the last roll(s) 1=en värdesiffra.
   *
   */
  public function GetAverage() {
    return round($this->GetTotal()/ count($this->rolls), 1);
  }
  /**
   * Prepare the histogram by calculate occurences for each key.
   *
   * @param array $values the values to prepare out the histogram from.
   */
  private function PrepareHistogram($values) {
    $this->res = array();
    foreach($values as $key => $value) {
      @$this->res[$value] .= '*'; // Use @ to ignore warning for not initiating variabel, not really nice but powerful.
    }
    ksort($this->res);
  }
   /**
   * Print the histogram
   *
   * @param array $values the values to print out the histogram from.
   */
  public function GetHistogram($values, $max) {
  
	$this->PrepareHistogram($values);
    // Prepare out a textual representation of the histogram
    $html = "<ol>";
   // foreach($res as $key => $val) {
     // $html .= "<li>{$val} </li>";
	  for($i = 1; $i <= $max; $i++) {
	  $val = isset($res[$i]) ? $res[$i] : null;
	  $html .= "<li>{$val}</li>";
    }
    $html .= "</ol>";

    return $html;
  }
 /**
   * Get the rolls as a string with each roll separated by a comma.
   *
   */
  public function GetRollsAsSerie() {
    $html = null;
    foreach($this->rolls as $val) {
      $html .= "{$val}, ";
    }
    return substr($html, 0, strlen($html) - 2);
  }


 
}