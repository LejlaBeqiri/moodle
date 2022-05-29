<?php
 include('includes/current_page.php');
 include('./includes/header.php');
 if(!isset($_SESSION)) { 
        session_start(); 
    } 

if(!isset($_SESSION['user_id'])){
     header("Location: ./index.php");
}
require './controllers/Homework/HomeworkController.php';

$hw = new Homework;


?>
 
<!DOCTYPE html>
<html>
    <head>
        <title>Upload</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
        <script src="./js/jquery-3.6.0.min.js"></script>

    </head>
    <body>


            <div class="signIncontanier-upload">

                <div class="loginBox-upload">
                    
                    <div class="back-upload">
                        
                        <img src="images/student3.png" alt="User">
                        
                        <h3>Your Profile</h3>
                        
                        <p><?php echo $_SESSION['name'] .' ' . $_SESSION['last_name'];?></p>
                        <p><?php echo $_SESSION['email'];?></p>

                        

                    </div>
                </div>


            </div>

  
    </body>

</html>