<?php
  require_once(MODUL . "Logger.php");
  Class Connection{
    private $db;

    public function connect(){
      $conf = parse_ini_file(ROOT . 'app.conf');
      try{
        $this->db = new PDO ('mysql:host=' .$conf["host"]. ';dbname=' .$conf["database"]. ';' ,$conf["user"],$conf["password"]);
        $this->db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAME'utf8'");
        $this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return ($this->db);
      }
      catch(PDOException $exception){
        Logger::log("Impossible de se connecter à la base de donnée : '".$exception->getMessage()."'.","ERROR");
        return(null);
      }
    }

    /**
     * Method that allow the user to disconnect the current object from a database.
     * 
     * @return void
     */
    public function disconnect(){
      $this->db = null;
    }

  }
 ?>
