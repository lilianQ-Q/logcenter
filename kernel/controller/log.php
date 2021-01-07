<?php
require_once(CORE . "Controller.php");
require_once(CORE . "Factory.php");

class CTRLlog extends Controller{

    public function index(){
        $a["Status"] = "cc c'est la ou on va render tous les logs sur une belle page wola";
        $this->set($a);
        $this->render("index", "blank");
    }

    public function create(){
        if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_GET["token"])){
            $a["Status"] = array(
                "success" => true,
                "message" => "yes ! we got a hit"
            );
        }
        else{
            $a["Status"] = array(
                "success" => false,
                "message" => "please use post request and define your token"
            );
        }
        $this->set($a);
        $this->render('index','blank');
    }

    public function new(){
        $this->loadModel("Log");
        //Récupérer le token de l'utilisateur.
        //Récupérer l'id de l'utilisateur et le mettre dans le $_POST
        //Check & insert
    }

}


?>