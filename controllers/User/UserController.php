<?php
include './core/Database.php';

class UserController{
    protected $user;

    public function __construct()
    {
        $this->user = new Database;
    }



}