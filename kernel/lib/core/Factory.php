<?php

$entity_path = MODUL . "entity/";
define("ENTITY_PATH", $entity_path);

class Factory{

  /**
   * Main method of factory class. It allows the user to create a new entity. Like a client or even a patch.
   * 
   * @param string $entity is the name of the object that you want to create.
   */
  public static function create($entity){
    $entity = strtolower($entity);
    if(file_exists(ENTITY_PATH . $entity . ".php")){
      require_once(ENTITY_PATH . $entity . ".php");
      return(new $entity());
    }
  }

}

?>