<?php
require_once(CORE . "Model.php");

class Application extends Model{
    protected $id_application;
    protected $name;
    protected $created;
    protected $modified;

    public function __construct()
    {
        $this->id_application = "";
        $this->name = "";
        $this->created = "";
        $this->modified = "";
        parent::__construct("APPLICATION", "id_application", false);
    }
}
?>