<?php

include './core/Database.php';

class AuthController
{
    protected $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    function emailExists($email)
    {
        $row = $this->db->pdo->prepare("SELECT 1 FROM users WHERE email=?");
        $row->execute([$email]);
        return $row->fetchColumn();
    }

    public function register($request)
    {
        //kontrollohet se useri a osht admin dhe ruhet vlera
        isset($request['is_admin']) ? $isAdmin = 1 : $isAdmin = 0;
        //merret passwordi prej metodes _POST ose GET dhe behet Hash
        $password = password_hash($request['password'], PASSWORD_DEFAULT);
        //krijohet nje query e cila sherben per te insertuar t'dhena
        //VALUES i ka :name,:email,:password,:is_admin t'cilat varen prej prej elementeve qe ndodhen ne array $request, ($request e ka metoden GET ose POST)
        $query = $this->db->pdo->prepare('INSERT INTO users (name, last_name, email, password, is_admin, role) VALUES (:name, :last_name, :email, :password, :role, :is_admin)');
        $query->bindParam(':name', $request['name']);
        $query->bindParam(':last_name', $request['lastName']);
        $query->bindParam(':email', $request['email']);
        $query->bindParam(':password', $password);
        $query->bindParam(':is_admin', $isAdmin);
        $query->bindParam(':role', $role);
        $query->execute();
        
        
    }

    public function login($request)
    {
        
        $query = $this->db->pdo->prepare('SELECT id, name, last_name, email, password, role_id FROM users WHERE email = :email');
        $query->bindParam(':email', $request['email']);
        $query->execute();

        $user = $query->fetch();

        //echo $user['name'];


        if(count($user) > 0 && password_verify($request['password'], $user['password']) && $user['is_admin']==1){
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['is_admin'] = $user['is_admin'];
            $_SESSION['role'] = $user['role'];
        
            header("Location: ./admindashboard.php");
        }
        elseif(count($user) > 0 && password_verify($request['password'], $user['password']) && $user['is_admin']==0){
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['is_admin'] = $user['is_admin'];
            $_SESSION['role'] = $user['role'];

            header("Location: ./index.php");
        }
    }
}
