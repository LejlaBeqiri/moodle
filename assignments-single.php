<?php
    include('./includes/header.php');
    $id=$_REQUEST['id'];
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
    if(!isset($_SESSION['user_id'])){
        header("Location: ./index.php");
    }

  
    require './controllers/Assignment/AssignmentController.php';

    
    $asm = new AssignmentController;
    $course_id =0;

    $asm = $asm->show($id);


    
?>


<!DOCTYPE html>
<html>
    <head> 
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    </head>
<body>


<table>
    <thead>
        <tr>
            <th style = "font-size:25px">Title</th>
            <th style = "font-size:25px">Desc.</th>                    
            <th style = "font-size:25px">Course</th>                    
            <th style = "font-size:25px">Due</th>                    
        </tr>
    </thead>
    <tbody>
        
        <tr>
        <td><?php echo $asm['title'] ?></td>
        <td>
            <?php 
                echo $asm['description'];
            ?>
        </td>
        <td>
        <?php 
            echo $asm['name'];       
        ?>
        </td>
        <td>
            <?php echo $asm['due'];?>
        </td>

    </tr>

        
    </tbody>
    </table>
    <?php 
    
    ?>
 
  
</body>
</html>