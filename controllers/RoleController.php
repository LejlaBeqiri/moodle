<?php 
require_once './core/Database.php';

class RoleController{
    protected $role;

    public function __construct(){
        $this->role = new Database;
    }

    public function all(){        
        $query = $this->role->pdo->query('SELECT * FROM roles');
        return $query->fetchAll();
    }
}