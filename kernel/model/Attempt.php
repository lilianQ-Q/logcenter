<?php
require_once(CORE . "Model.php");

$conf = array(
  "nb_attempt" => 3
);

define('CONF_ATTEMPT', $conf);

class Attempt extends Model{
  protected $id_attempt;
  protected $address;
  protected $modified;
  protected $created;

  /**
   * Constructor of the Attempt class.
   */
  public function __construct()
  {
    $this->id_attempt = "";
    $this->address = "";
    $this->modified = date("Y-m-d");
    $this->created = date("Y-m-d");
    parent::__construct("ATTEMPT","id_attempt", true);
  }

  /**
   * Method that allow the user to set the current object's address.
   * 
   * @param string $address is an ip address.
   * @return void
   */
  public function setAddress($address){
    $this->address = $address;
  }

  /**
   * Method that allow the user to check if the address passed trought parameters attempted to use the api 3 times.
   * 
   * @param string $address is an ip address.
   * @return bool return true if the address has already 3 attempt else return false.
   */
  public function tooManyAttempt($address){
    try{
      $query = $this->connect()->prepare("SELECT COUNT(*) FROM ATTEMPT WHERE address = :address");
      $query->bindParam("address",$address,PDO::PARAM_STR);
      $query->execute();
      $this->disconnect();
      return($query->fetchColumn() >= CONF_ATTEMPT["nb_attempt"]);
    }
    catch(Exception $exception){
      Logger::log("Error while 'COUNT' from 'ATTEMPT'. Please check your request syntax or the database connection.","ERROR");
      return(false);
    }
  }
}
?>