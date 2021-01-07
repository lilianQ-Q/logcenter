<?php
require('Connection.php');

Class Model extends Connection{
  protected $table;
  protected $primary;
  protected $foreign;
  protected $prime;
  protected $needEncryption;
  protected $arraysys;

  /**
   * Main constructor of Model class.
   */
  public function __construct($table, $primary, $prime = false, $needEncryption = false){
    $this->table = $table;
    $this->primary = $primary;
    $this->prime = $prime;
    $this->needEncryption = $needEncryption;
    $this->arraysys = array('table', 'primary', 'foreign', 'arraysys', 'prime', 'needEncryption');
  }

  /**
   * Method that allow the user to check if the current model is a prime model. 
   * Which means that you need a special authorization to insert data in.
   * 
   * @return bool return true if model is prime else return false.
   */
  public function isPrime(){
    return($this->prime);
  }

  /**
   * Retourne si oui ou non la clé primaire est une association de plusieurs clés étrangères.
   * 
   * @return bool Multiple clé primaire ou non
   */
  public function multiplePrimary(){
    $primarys = explode(";",$this->primary);
    if(count($primarys >= 2)){
      $multiple = true;
    }
    else{
      $multiple = false;
    }
    return(count($primarys >= 2));
  }

  /**
   * Method thata allow the user to insert model's data into the concerned database.
   * 
   * @return bool Return true if the query has been executed else return false.
   */
  public function create(){
    $col = '';
    $val = '';
    foreach ($this as $key => $value){
      if(!in_array($key, $this -> arraysys) && $key!=$this->primary){
        if($key != null){
          $col.= $key.',';
          $val .= "'".str_replace("'","\'",$value)."',";
        }
      }
    }
    $col = substr($col,0,-1);
    $val = substr($val,0,-1);
    $sql = "INSERT INTO {$this -> table} ({$col}) VALUES ({$val})";
    try{
      $request = $this->connect()->prepare($sql);
      $request->execute();
      $count = $request->rowCount();
      $request = $this->disconnect();
      return($count > 0);
    }
    catch(Exception $exception){
      Logger::log("Impossible d'effectuer une requête INSERT dans la table '".$this->table."'. Vérifiez la connexion à la base de donnée ou les droits que vous possédez sur celle-ci.");
      return(false);
    }
  }

  /**
   * Method that allow the user to read a data from an id into the concerned database and load them on the current object.
   * 
   * @param int $id is the id of the data that you want to get the information.
   * @return array [success][message] if the query has been executed success = true, else success = false.
   */
  public function read($id){
    try{
      $query = $this->connect()->prepare("SELECT * FROM {$this->table} WHERE {$this->primary} = :id");
      $query->bindParam("id",$id,PDO::PARAM_STR);
      $query->execute();
      $this->disconnect();
      $data = $query->fetch(PDO::FETCH_ASSOC);
      if(!empty($data)){
        foreach ($data as $key => $value) {
          $this -> $key = $value;
        }
        return(array(
          "success" => true,
          "message" => "Able to get line number $id of '{$this->table}' table."
        ));
      }
      return(array(
        "success" => false,
        "message" => "/!\ Unable to get line number $id of '{$this->table}' table."
      ));
    }
    catch(Exception $exception){
      Logger::log("Impossible de lire la ligne ".$id." de la table :'". $this->table."'. Vérifiez la connexion à la base de données ou les droits que vous possedez dessus.\n [SQL] : '".$query."'.","ERROR");
      return(array(
        "success" => false,
        "message" => "error while reading into the database"
      ));
    }
    //return true ou false si ça a réussi
  }

  /**
   * Method that allow the user to update a line of the database from the current object.
   * 
   * @return bool Return true if the query has been executed else return false.
   */
  public function updateAll(){
    $cle = $this->primary;
    $id = $this->$cle;
    $sql = "UPDATE {$this -> table} SET ";
    foreach ($this as $key => $value) {
      if(!in_array($key, $this -> arraysys) && $key!=$this->primary){
        $sql .= " $key = '$value',";
      }
    }
    $sql = substr($sql,0,-1);
    $sql .=" WHERE ". $this -> primary." = $id";
    try{
      $this->connect()->exec($sql);
      $this->disconnect();
    }
    catch(Exception $exception){
      Logger::log("Impossible de mettre la ligne ".$id." dans la table '".$this->table."'. Vérifiez la connexion à la base de données ou les droits que vous possedez dessus.\n[SQL] : '".$sql."'.","ERROR");
    }
  }

  /**
   * Method that allow the user to update a line into the database.
   * 
   * @param int $num is the id of the line that you want to update.
   * @param string $prop is the name of the column you want to update.
   * @param string $newval is the new value you want to put into the table.
   * 
   * @return bool Return true if the query has been executed else return falses. 
   */
  public function update($num, $prop, $newval){
    try{
      $request = $this->connect()->prepare("UPDATE ".$this->table." SET ".$prop." = :value WHERE ".$this->primary." = :num");
      //Vérifier si c'est un entier ou un string pour value
      $request->bindParam(":value",$newval,PDO::PARAM_STR);
      $request->bindParam(":num",$num,PDO::PARAM_INT);
      $request->execute();
      $this->disconnect();
      $count = $request->rowCount();
      return($count > 0);
    }
    catch(Exception $exception){
      Logger::log("Impossible de mettre la ligne ".$num." à jour dans la table '".$this->table."'. Vérifiez la connexion à la base de données ou les droits que vous possedez dessus.","ERROR");
    }
    return(false);
  }

  /**
   * Method that allow the user to delete a line into the database.
   * 
   * @param int $id is the id of the line that you want to delete.
   * @return bool Return true if the query has been executed else return false.
   */
  public function delete($id){
    //TODO, test this line 147.
    //$request = $this->multiplePrimary() ? $this->connect()->prepare("DELETE FROM ".$this->table." WHERE ".explode(";",$this->primary)[0]." = :id") : $this->connect()->prepare("DELETE FROM ".$this->table." WHERE ".$this->primary." = :id");
    try{
      if($this->multiplePrimary()){
        $primarys = explode(";",$this->primary);
        $request = $this->connect()->prepare("DELETE FROM ".$this->table." WHERE ".$primarys[0]." = :id");
      }
      else{
      $request = $this->connect()->prepare("DELETE FROM ".$this->table." WHERE ".$this->primary." = :id");
      }
      $request->bindParam('id',$id,PDO::PARAM_INT);
      $request->execute();
      $count = $request->rowCount();
      $this->disconnect();
      return($count > 0);
    }
    catch(Exception $exception){
      Logger::log("Impossible de supprimer la ligne ".$id." dans la table '".$this->table."'. Vérifiez la connexion à la base de données ou les droits que vous possedez dessus.","ERROR");
    }
    return(false);
  }

  /**
   * Method that allow the user to get a list of all lines from a table through a parameter.
   * 
   * @param mixed $cond is the condition to sort the list. It can be an integer or a string.
   * @return array return an array of query's concerned lines.
   */
  public function list($cond = 1){
    /** Faire en sorte que si $cond est un tableau alors il boucle dedans et re écris la requête */
    $tmp = array();
    try{
      $request = $this->connect()->prepare("SELECT * FROM ".$this->table." WHERE ".$cond);
      $request->execute();
      while($fetch = $request->fetch(PDO::FETCH_ASSOC)){
        $tmp[] = $fetch;
      }
      $request = $this->disconnect();
      return($tmp);
    }
    catch(Exception $exception){
      Logger::log("Impossible d'obtenir la liste des lignes de la table '".$this->table."'. Vérifiez la connexion à la base de données ou les droits que vous possedez dessus.","ERROR");
    }
    return(array());
  }

  /**
   * Allow the user to move model's data into a key / value array. Used in the read process.
   * deprecated : totable()
   * 
   * @param array $excluse is an array which contains propertie(s) to exclude.
   * @return array return current object properties and data into a key value array.
   */
  public function toArray($exclude = []) {
    error_reporting(1 | 1 | 1 | 0); /*error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);*/
    foreach($this as $propertie => $value) {
      if($propertie != "arraysys" && !in_array($propertie, $this->arraysys) && !in_array($propertie, $exclude)){
        $tab[$propertie] = $value;
      }
    }
    return($tab);
  }

  public function toForm($attributes = []){
    $form = "<form id='main_form' action ='' autocomplete='off' style='margin-top: 70px;'>\n";
    foreach($attributes as $attribute => $value){
      $input_type = "hidden";
      $input_value = "";
      $input_placeholder = "";

      if($attribute == "id_".lcfirst(get_class($this))){
        $input_type = "hidden";
      }
      else if($attribute == "created" || $attribute == "modified"){
        $input_type = "hidden";
        $input_value = date("Y-m-d");
      }
      else if(is_bool($value)){
        $input_type = "radio";
      }
      else{
        $input_type = "text";
        $input_placeholder = "$attribute";
      }

      $form .= $input_type === "radio" ? '<label class="b-contain" style="margin-top: 15px;">'."\n".'<span>'.ucfirst($attribute).'</span>'."\n".'<input type="'.$input_type.'" name="'.$attribute.'" id="'.$attribute.'">'."\n".'<div class="b-input"></div>'."\n".'</label>'."\n" : "<input type='$input_type' name='$attribute' id='$attribute' placeholder='$input_placeholder' value='$input_value'>\n";
      //todo a améliorer avec une liste déroulante pour les clés étrangères, donc nouvelle méthode.
      
    }
    $form .= "</form>";
    return($form);
  }

  //A améliorer en remplaçant par getLibelle & getValue EN PLUS WTFFF C'EST PAREIL QUE TOTABLE ???
  /**
   * deprecated
   */
  public function getAttribute(){
    $tab = array();
    foreach($this as $k => $v){
      $tab[$k] = $v;
    }
    return($tab);
  }

  /**
   * Transfert les données en commun de $_POST au model en question
   * 
   * @return array Tableau de checklist (ex : Tâches dépendre d'autre tâches). 
   */
  public function posttomodel() {
    $tmp = array();
    foreach ($_POST as $k => $v) {
      $this->$k = $v;
      if($k == "checklist"){
        foreach ($_POST[$k] as $kk => $vv){
          $tmp[] = $vv;
        }
      }
    }
    return($tmp); 
  }

  /**
   * Rempli le modèle courant, par les mêmes attributs qu'un autre modèle
   * Méthode d'historisation.
   * 
   * @return void
   */
  public function modeltomodel($model){
    foreach($model as $k => $v){
      if($k == "id_".strtolower(substr(get_class($this),8))){
        $this->{"id_".strtolower(substr(get_class($this),8))} = "$v";
      }
      if($k != "table" && $k != "primary" && strpos($k,"id_") === false){
        $this->$k = $v;
      }
    }
  }

  /**
   * Fonction qui trouve les clés étrangères, qui les mets dans le tableau de clé étrangère du controller en question
   * 
   * @return array Tableau de clés étrangères
   */
  public function getForeign(){
    $classname = "id_".strtolower(get_class($this));

    foreach($this as $k => $v){
      if("$k" != "$classname" && strpos("$k","id_") !== false){
        if(strpos($k,"2") !== false){
          $this -> foreign[ucfirst(substr("$k",3,-1))] = $v;
        }
        else{
          $this -> foreign[ucfirst(substr("$k",3))] = $v;
        }
      }
    }
    return ($this -> foreign);
  }

  /**
   * Method that allow the user to get the main string propertie of a model. Exemple : "libelle" or "name".
   * 
   * @return string return the model's main string propertie.
   */
  public function getLibelle(){
    //Norme de l'utilisateur, pour améliorer les fonctions par défaut des controllers. Exemple copier coller les lists delete etc...
    $possibleProperties = ["libelle","name"];
    $mainPropertie = "libelle";
    foreach($possibleProperties as $propertie){
      $mainPropertie = property_exists($this, $propertie) ? $propertie : "libelle";
    }
    return($mainPropertie);
  }

  /**
   * Method that allow the user to get a Model's propertie value throught a parameter.
   * 
   * @param string $propertie is the name of the propertie that you want to get.
   * @return mixed return the propertie's value if this one does exists, else return an error message.
   */
  public function getPropertie($propertie = "libelle"){
    $res = property_exists($this, $propertie) ? $this->$propertie : "error, no such properties.";
    return($res);
  }

  /**
   * Retourne la valeur de l'attribue passé en paramètre
   * 
   * @return string Value de l'attribute de de l'objet modèle
   */
  public function getValue($attribute){
    return($this->$attribute);
  }

  /**
   * Method that allow the user to check if postProperties are the same that the current object.
   * 
   * @param array $postProperties must be $_POST constant.
   * @return array if succedd return an array with success key to true, else success key to false. ['success','message']
   */
  public function checkPostProperties($postProperties){
    //Vérifier si le token utilisé correspond à l'utilisateur en question.
    $classProperties = get_class_vars(get_class($this));
    $isOk = null;
    if(count($postProperties) === (count($classProperties)-count($this->arraysys))){
      $res = array(
        "success" => true,
        "message" => "postProperties and classProperties are the same !"
      );
      foreach($postProperties as $propertie => $value){
        if(array_key_exists($propertie, $classProperties) && $isOk || $isOk === null){
          $isOk = true;
        }
        else{
          $isOk = false;
          $res = array(
            "success" => false,
            "message" => "postProperties and classProperties are not the same !"
          );
        }
      }
      return($res);
    }
    else{
      return(array(
        "success" => false,
        "message" => "Missing properties on postData."
      ));
    }
  }
}
?>
