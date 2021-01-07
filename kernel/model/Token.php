<?php
require_once(CORE . "Model.php");

class Token extends Model{
    protected $id_token;
    protected $token;
    protected $id_user;
    protected $created;
    protected $modified;

    public function __construct()
    {
        $this->id_token = "";
        $this->token = "";
        $this->id_user = "";
        $this->created = "";
        $this->modified = "";
        parent::__construct("TOKEN", "id_token", false);
    }
}

?>