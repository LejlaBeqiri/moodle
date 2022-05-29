<?php
    include('./includes/header.php');
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
    if(!isset($_SESSION['user_id'])){
        header("Location: ./index.php");
    }
    $course_id_request=$_REQUEST['id'];
    $course_name_request=$_REQUEST['name'];
   
    $assignment_id='';
    $title= '';
    $description = '';
    $due = '';
    $edit_state = false;
    require './controllers/Assignment/AssignmentController.php';

    
    $asm = new AssignmentController;


    
    if(isset($_POST['save'])){
        $asm->store($_POST);
        header('Location: ./assignments.php');
    }
    if(isset($_GET['del'])){
        $asm->destroy($_GET["del"]);
        header('Location: ./assignments.php');
    }

   
    if(isset($_GET['edit'])){
        $assignment_id = $_GET['edit'];
        $title= $_GET['title'];
        $description= $_GET['description'];
        $due= $_GET['due'];
        $edit_state = true;
    }

  
    $currentCourse = $asm->edit($assignment_id);

    if(isset($_POST['update'])){
        $asm->update($assignment_id,$_POST);
    }
    
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
            <th class ="actionclass" colspan = "2">Action</th>
        </tr>
    </thead>
    <tbody>

 <div class="
 "></div>
        <?php foreach($asm->get_assignments_from_course($course_id_request) as $row ){ ?>
            <tr>
            <td><?php echo $row['title'] ?></td>
            <td class="excerpt">
                <?php 
                   echo $row['description'];
                ?>
            </td>
            <td>
            <?php 
                echo $course_name_request;       
            ?>
            </td>
            <td>
                <?php echo $row['due'];?>
            </td>
            <td class ="updateclass">
                <a class ="btn" style="text-decoration:none;" href="assignments-single.php?id=<?php echo $row['id']; ?>">Show More</a>
            </td>

        </tr>
        <?php } ?>
        
    </tbody>
    </table>
    <?php 
    
    ?>
 

</body>
</html>