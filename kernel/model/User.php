<?php 
require_once(CORE . "Model.php");

class User extends Model{
    protected $id_user;
    protected $name;
    protected $created;
    protected $modified;

    /**
     * Allow the user to create a new User.
     * Main constructor of User class.
     */
    public function __construct()
    {
        $this->id_user = "";
        $this->name = "";
        $this->created = "";
        $this->modified = "";
        parent::__construct("USER","id_user",false);
    }


}
?>