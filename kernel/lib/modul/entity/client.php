<?php

class Client{
  private $address;
  private $country;

  /**
   * Default constructor of the Ip class.
   */
  public function __construct()
  {
    $this->address = $this->getInComing();
    $this->country = "nowhere";
  }

  /**
   * Method that allow the user to get the incoming address.
   * 
   * @return string return the ip of the request.
   */
  public function getInComing(){
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
      $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
      $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
      $ip = $_SERVER['REMOTE_ADDR'];
    }
    return($ip);
  }

  /**
   * Method that allow the user to get the current object's address.
   * 
   * @return string current object's address.
   */
  public function getAddress(){
    return($this->address);
  }

  /**
   * Method that allow the user to get the current object's country.
   * 
   * @return string current object's country.
   */
  public function getCountry(){
    return($this->country);
  }

  /**
   * Method that allow the user to set the current object's address.
   * 
   * @param string $address is an Ip address.
   * @return void
   */
  public function setAddress($address){
    $this->address = $address;
  }

  /**
   * Method that allow the user to set the current object's country.
   * 
   * @param string $country is a country.
   * @return void
   */
  public function setCountry($country){
    $this->country = $country;
  }
}

?>