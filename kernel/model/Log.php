<?php
require_once(CORE . "Model.php");

class Log extends Model{
    protected $id_log;
    protected $log;
    protected $id_user;
    protected $id_application;
    protected $created;
    protected $modified;

    public function __construct()
    {
        $this->id_log = "";
        $this->log = "";
        $this->id_user = "";
        $this->id_application = "";
        $this->created = "";
        $this->modified = "";
        parent::__construct("LOG", "id_log", false);
    }
}
?>