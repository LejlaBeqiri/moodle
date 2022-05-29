<?php
    include('includes/current_page.php');


    if(!isset($_SESSION)) { 
        session_start(); 
    } 

    if(!isset($_SESSION['user_id'])){
        header("Location: ./index.php");
    }

    require './controllers/Homework/HomeworkController.php';

        
    $hw = new Homework;
    $homeworks = $hw->myHomework($_SESSION['user_id']);

    $assignment_title= '';
    $student_id= '';
    $user = null;
    if(isset($_GET['edit'])){
        $asm_id = $_GET['edit'];
        $student_id= $_GET['student_id'];
        $assignment_title= $_GET['assignment_title'];
        $user = $hw->user($student_id)[0];
      
    }
    
    if(isset($_GET['del'])){
        $hw->destroy($_GET["del"]);
        header('Location: ./homework.php');
    }

    if(isset($_POST['update'])){

        $hw->update($asm_id,$_POST);
        header('Location: ./homework.php');

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
<?php include('includes/header.php');?>




<table style="width: 85%;">
    <thead>
        <tr>
            <th style = "font-size:25px">Title</th>
            <th style = "font-size:25px">Desc.</th>                    
            <th style = "font-size:25px">Score</th>                    
            <th style = "font-size:25px">Semester</th>                    
            <th style = "font-size:25px">Course</th>       
            <th style = "font-size:25px">Evaluated</th>                    
            <th style = "font-size:25px">File</th>                    
            <th class ="actionclass" >Action</th>
        </tr>
    </thead>
    <tbody>

        <?php foreach( $homeworks as $row ){ ?>
            <tr>
                <td><?php echo $row['title'] ?></td>
                <td>
                    <?php 
                    echo $row['description'];
                    ?>
                </td>
                <td>
                    <?php 
                        echo $row['score'];       
                    ?>
                </td>
                <td>
                    <?php 
                        echo $row['semester'];       
                    ?>
                </td>
                <td>
                    <?php 
                        $course = $hw->get_course($row['course_id']);
                        echo $course;     
                    ?>
                </td>
                <td>
                    <?php 
                        echo $row['evaluated'];       
                    ?>
                </td>
                <td>
                    <a class='button2' href="<?php
                        $imageURL= 'uploads/assignment_media/'. $row['file'];
                        echo $imageURL;
                        ?> 
                        "target="_blank"><?php echo $row['file'];?></a>
                </td>
   

                <td class ="updateclass">
                    <a class ="del_btn" style="padding:17px 5px;" href="homework.php?del=<?php echo $row['id']; ?>">Delete</a>
                </td>
                <?php if($_SESSION['role'] == 1){?>
                    <td class ="updateclass">
                        <a class ="btn" style="padding:17px 5px;" href="homework.php?edit=<?php echo $row['id']; ?>&assignment_title=<?php echo $row['title'] ?>&score=<?php echo $row['score'] ?>&student_id=<?php echo $row['student_id'] ?>">Edit</a>
                    </td>
                <?php }?>

            </tr>
        <?php } ?>
        
    </tbody>
    </table>
    <?php if($_SESSION['role'] == 1){?>
    <form method="post" action ="">
            <div class ="input-group">
                <label>Score</label>
                <input type="number" value="<?php echo $score; ?>" name="score">
                <label>Student</label>
                <input disabled placeholder=<?php
                 if(isset($user)){
                     echo $user['name'];
                 }
                 else{echo '';}
                 
                 ?>>
                <label>Assignment Title</label>
                <input disabled placeholder=<?php echo $assignment_title;?>>

            </div>
            
            <div class ="input-group">
                <button type="submit" name="update" class="btn">Update</button>
            </div>
     </form>
<?php } ?>

</body>
</html>