<?php 
require_once './core/Database.php';
include './controllers/RoleController.php';

$roleController = new RoleController;

$res = $roleController->all();

print_r($res);