<?php
require_once(CORE . 'Controller.php');
require_once(CORE . 'Factory.php');
require_once(MODUL . 'Logger.php');

class CTRLmain extends Controller
{

    public function index()
    {
        $this->loadModel("Log");
        $this->Log->read(1);
        $a["User"] = $this->Log->toArray();
        $this->set($a);
        $this->render("index","blank");
    }

    public function error()
    {
        $a["Status"] = array(
            "success" => false,
            "message" => "An error has occured, the method that you tried to use does not exists. (404)",
            "type" => "user_error (404)"
        );
        $this->set($a);
        $this->render("error", "blank");
    }
}
?>