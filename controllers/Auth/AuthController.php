<?php

include './core/Database.php';
require './Exceptions/AuthException.php';


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
        $password = password_hash($request['password'], PASSWORD_DEFAULT);

        $query = $this->db->pdo->prepare('INSERT INTO users (name, last_name, email, password, admin, role_id) VALUES (:name, :last_name, :email, :password, :is_admin, :role)');
        $query->bindParam(':name', $request['name']);
        $query->bindParam(':last_name', $request['last_name']);
        $query->bindParam(':email', $request['email']);
        $query->bindParam(':password', $password);
        $query->bindParam(':is_admin', $request['is_admin']);
        $query->bindParam(':role',$request['selectRole']);
        $query->execute();
        
        
    }

    public function login($request)
    {
        
        $query = $this->db->pdo->prepare('SELECT id, name, last_name, email, password, role_id, admin FROM users WHERE email = :email');
        $query->bindParam(':email', $request['email']);
        $query->execute();

        $user = $query->fetch();


        if( $user && password_verify($request['password'], $user['password']) && $user['admin']==1){
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['is_admin'] = $user['admin'];
            $_SESSION['role'] = $user['role_id'];
        
            header("Location: ./admindashboard.php");
        }
        elseif($user && password_verify($request['password'], $user['password']) && $user['admin']==0){
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['is_admin'] = $user['admin'];
            $_SESSION['role'] = $user['role_id'];

            header("Location: ./index.php");
        }
        throw new AuthException('Wrong credentials',422);
        header("Location: ./signin.php");
    }
}
