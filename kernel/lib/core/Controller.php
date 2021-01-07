<?php
require_once(MODUL . "Logger.php");
class Controller
{
  protected $viewVar = array();

  /**
   * Method that allow the user to load a Model. Doesn't need to write '.php' extension. Use : loadModel("User") || loadModel("User.php")
   * 
   * @param mixed $model. String or array which contains model(s) name.
   */
  protected function loadModel($model)
  {
    if(!is_array($model)){
      $model = ucfirst(str_replace(".php", "", $model));
      if(file_exists(MODEL . "$model.php")){
        require_once(MODEL . "$model.php");
        $this->$model = new $model(); 
      }
      else{
        Logger::log("Unable to load model : ( $model ). File does not exist. Path : (" . MODEL . $model . ").","ERROR");
      }
    }
    else{
      foreach($model as $modelName){
        $modelName = ucfirst(str_replace(".php", "", $modelName));
        if(file_exists(MODEL . "$modelName.php")){
          require_once(MODEL . "$modelName.php");
          $this->$modelName = new $modelName();
        }
        else{
          Logger::log("Unable to load model : ( $model ). File does not exist. Path : (" . MODEL . $model . ").","ERROR");
        }
      }
    }
  }

  /**
   * Method that allow the user to load a modul. Doesn't need to write the '.php' extension. Use : loadModul("Logger") || loadModul(array("Logger","Crypter")).
   * 
   * @param mixed $modul. String or array which contains modul(s) name.
   * @return void
   */
  protected function loadModul($modul){
    if(!is_array($modul)){
      $modul = ucfirst(strtolower(str_replace(".php","",$modul))).".php";
      if(file_exists(MODUL . "$modul")){
        require_once(MODUL . "$modul");
      }
      else{
        Logger::log("Unable to load modul : ( $modul ). File does not exist. Path : (" . MODUL . $modul . ").","ERROR");
      }
    }
    else{
      foreach($modul as $modulName){
        $modulName = str_replace(".php","",$modulName).".php";
        if(file_exists(MODUL . "$modulName")){
          require_once(MODUL . "$modulName");
        }
        else{
          Logger::log("Unable to load modul : ( $modulName ) in array. File does not exist. Path : (" . MODUL . $modulName . ").","ERROR");
        }
      }
    }
  }

  /**
   * Méthode permettant d'extraire les données du tableau, d'intérpréter, et de charger la vue passé en paramètre
   * 
   * @param string $view Nom de la vue à charger ex : index.php Pourquoi ne pas la mettre en default ?
   * @param string $type Le type de layout à charger : login, home, crud, default
   */
  protected function render($view, $type = "default")
  {
    extract($this->viewVar);
    ob_start(); //interprete
    $controller = str_replace('CTRL', '', get_class($this));
    require(VIEW . $controller . '/' . $view . '.php');
    $content = ob_get_clean();
    if ($type == null) {
      require(VIEW . 'layout/default.php');
    } else {
      try {
        require(VIEW . "layout/$type.php");
      } catch (Exception $e) {
        require(VIEW . "layout/default.php");
      }
    }
  }

  /**
   * Method that allow the user to send data to the view.
   */
  protected function set($value)
  {
    $this->viewVar = array_merge($this->viewVar, $value);
  }

  /**
   * Method that allow the user to check the request sent to the server and ban an Ip address if this one is not able to use the api.
   * 
   * @return void
   */
  protected function checkRequest()
  {
    $res = array();
    if (file_exists(MODEL . "Licence.php") && file_exists(MODEL . "User.php") && file_exists(MODEL . "Attempt.php")) {
      $this->loadModel(["Licence", "User", "Attempt", "Banned", "IpAddress"]);
      $client = Factory::create("client");

      if (isset($_GET["token"])) {
        $token = $_GET["token"];
        $this->Banned->setAddress($client->getAddress());
        if ($this->Licence->tokenExists($token) && !$this->Banned->banned()) {
          $isOk = false;
          $id_user = $this->Licence->getUserIdByToken($token);
          $userIpAddresses = $this->IpAddress->list("id_user = $id_user");
          foreach ($userIpAddresses as $Ip) {
            if (!$isOk && $client->getAddress() == $Ip["address"] || $Ip["address"] == "%") {
              $isOk = true;
            }
          }
          if ($isOk) {
            $res = array(
              "success" => true,
              "message" => "All checks are done without error."
            );
          } else {
            $res = array(
              "success" => false,
              "message" => "You're not able to use this token. Please use the right ip address for this one.",
              "type" =>  "user_error"
            );
            if ($this->Attempt->tooManyAttempt($client->getAddress())) {
              $this->Banned->setAddress($client->getAddress());
              $this->Banned->create();
              Logger::log("A client at [" . $client->getAddress() . "] failed to use the api too many times. He has been blacklisted because he found the token but didn't use the proper ip address.");
            } else {
              $this->Attempt->setAddress($client->getAddress());
              $this->Attempt->create();
              Logger::log("A client at [" . $client->getAddress() . "] failed to use the api. Added to attempt list because he found the token but didn't use the proper ip address.");
            }
          }
        } else {
          $this->Banned->setAddress($client->getAddress());
          if ($this->Banned->banned()) {
            $res = array(
              "success" => false,
              "message" => "It seems that your ip address has been blacklisted. If you think that's an error please contact support."
            );
          } else {
            $res = array(
              "success" => false,
              "message" => "This token does not exists. If you think that's an error please contact support.",
              "type" => "user_error"
            );
            if ($this->Attempt->tooManyAttempt($client->getAddress())) {
              $this->Banned->setAddress($client->getAddress());
              $this->Banned->create();
              Logger::log("A client at [" . $client->getAddress() . "] failed to use the api too many times. He has been blacklisted because he used an invalid token.");
            } else {
              $this->Attempt->setAddress($client->getAddress());
              $this->Attempt->create();
              Logger::log("A client at [" . $client->getAddress() . "] failed to use the api. Added to attempt list because he used an invalid token.");
            }
          }
        }
      } else {
        $res = array(
          "success" => false,
          "message" => "Please provide a token through url.",
          "type" => "user_error"
        );
      }
    } else {
      $res = array(
        "success" => false,
        "message" => "Fail to check incoming sources. Framework unable to load models.",
        "type" => "framework_error"
      );
      Logger::log("Fail to check incoming sources. [Framework] -> Model[(Licence|User|Attempt)] not found.", "ERROR");
    }
    return ($res);
  }

  /**
   * Method that allow controllers to create a new entity into the database. If the model is a 'prime' model, then it checks if the user is allowed to create a new line into the database.
   * 
   * @param void
   * @return void
   */
  public function create()
  {
    $a["Status"] = array(
      "message" => "this method does not exists ont the main controller"
    );
    if (get_class($this) !== "CTRLmain") {
      $a["Status"] = array(
        "success" => false,
        "message" => "Please use post request to use this method."
      );
      if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET["token"])) {
        if ($this->checkRequest()["success"]) {
          $this->loadModel(ucfirst(substr(get_class($this), 4)));
          if (!$this->{ucfirst(substr(get_class($this), 4))}->isPrime()) {
            //Si le modèle n'est pas un modèle prime. Sinon vérifier que l'utilisateur en question peut écrire.
            if ($this->{ucfirst(substr(get_class($this), 4))}->checkPostProperties($_POST)["success"]) {
              $this->{ucfirst(substr(get_class($this), 4))}->posttomodel();
              if ($this->{ucfirst(substr(get_class($this), 4))}->create()) {
                $a["Status"] = array(
                  "success" => true,
                  "message" => "insert completed"
                );
              } else {
                $a["Status"] = array(
                  "success" => false,
                  "message" => "Fail to insert data into database :("
                );
              }
            } else {
              $a["Status"] = $this->${ucfirst(substr(get_class($this), 4))}->checkPostProperties($_POST);
            }
          }
          else{
            $this->loadModel(["User","Licence"]);
            $this->User->read($this->Licence->getUserIdByToken($_GET["token"]));
            if($this->User->isAdmin()){
              if ($this->{ucfirst(substr(get_class($this), 4))}->checkPostProperties($_POST)["success"]) {
                $this->{ucfirst(substr(get_class($this), 4))}->posttomodel();
                if ($this->{ucfirst(substr(get_class($this), 4))}->create()) {
                  $a["Status"] = array(
                    "success" => true,
                    "message" => "insert completed",
                    "data_inserted" => array_diff_key($this->{ucfirst(substr(get_class($this), 4))}->toArray(), array_fill_keys(["foreign", "prime", "needEncryption"], ""))
                  );
                } else {
                  $a["Status"] = array(
                    "success" => false,
                    "message" => "Fail to insert data into database :("
                  );
                }
              } else {
                $a["Status"] = $this->{ucfirst(substr(get_class($this), 4))}->checkPostProperties($_POST);
              }
            }
            else{
              $a["Status"] = array(
                "success" => false,
                "message" => "You can't write into this model because it is a 'prime' model. Please ask for permissions. /!/ not admin /!/"
              );
            }

          }
        } else {
          $a["Status"] = $this->checkRequest();
        }
      }
    }
    $this->set($a);
    $this->render('index', 'blank');
  }

  public function list(){
    $a["Status"] = array(
      "message" => "This method does not exists on the main controller"
    );
    $this->loadModel(ucfirst(substr(get_class($this), 4)));
    $a["Status"] = array(
      "success" => true,
      "message" => "pute",
      "data" => $this->{ucfirst(substr(get_class($this), 4))}->list()
    );
    $this->set($a);
    $this->render("index","blank");
  }
}
