<?php
require_once './core/Database.php';

    if(isset($_POST['catid'])){
        
        $db = new Database;

        $stmt =$db->pdo->prepare("SELECT * FROM courses WHERE category = ". $_POST['catid']);
        $stmt->execute();
        $courses = $stmt->fetchAll();
        echo json_encode($courses);
    }

    function loadCategories(){   

        $db = new Database;
        

        $stmt = $db->pdo->prepare("SELECT * FROM category");
        $stmt->execute();
        $categories = $stmt->fetchAll();
        return $categories;
    }

?>