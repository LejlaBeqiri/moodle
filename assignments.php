<?php
    include('./includes/header.php');
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
    if($_SESSION['role']==2){
        header("Location: ./index.php");

    }

    $name = '';
    $edit_state = false;
    require './controllers/Assignment/AssignmentController.php';

    
    $asm = new AssignmentController;
    $course_id =0;

    
    if(isset($_POST['save'])){
        $course->store($_POST);
        header('Location: ./assignments.php');
    }
    if(isset($_GET['del'])){
        $course->destroy($_GET["del"]);
        header('Location: ./assignments.php');
    }

   
    if(isset($_GET['edit'])){
        $course_id = $_GET['edit'];
        $name= $_GET['name'];
        $edit_state = true;
    }

  
    $currentCourse = $asm->edit($course_id);

    if(isset($_POST['update'])){
        $course->update($course_id,$_POST);
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
            <th style = "font-size:25px">Description</th>                    
            <th style = "font-size:25px">Course</th>                    
            <th style = "font-size:25px">Due</th>                    
            <th class ="actionclass" colspan = "2">Action</th>
        </tr>
    </thead>
    <tbody>

        <?php print_r($asm->all())?>
        <?php foreach($asm->all() as $row ){ ?>
            <tr>
            <td><?php echo $row['title'] ?></td>
            <td>
                <?php 
                   $prof = $asm->professor($row['professor_id'])[0];
      
                   echo $prof['name'];

                ?>
            </td>
            <td>
            <?php 
                echo $row['semester'];       
            ?>
            </td>
            <td class ="editclass">
                <a class ="edit_btn" href="coursepanel.php?edit=<?php echo $row['id']; ?>&name=<?php echo $row['name']?>&semester=<?php echo $row['semester'] ?>">Edit</a>
            </td>
            <td class ="updateclass">
            <a class ="del_btn" href="coursepanel.php?del=<?php echo $row['id']; ?>">Delete</a>
            </td>
        </tr>
        <?php } ?>
        
    </tbody>
    </table>
    <form method="post" action ="">
            <input type ="hidden" name="course_id" value="<?php echo $course_id; ?>">
            <input type ="hidden" name="name" value="<?php echo $name; ?>">

            <div class ="input-group">
                <label>Course Title</label>
                <input type="text" value="<?php echo $name; ?>" name="coursename">

                <label>Professor</label>
                <select name = "selectProfessor">
                    <?echo 'here';?>
                        <?php foreach($asm->professors() as $row ){ ?>
                            <option value="<?php echo $row['id'] ;?>"><?php echo $row['name']?></option>
                    
                        <?php } ?>
                </select>   
                <label>Semester</label>
                <select name = "selectSemester">
                    <option value="1">Semester 1</option>
                    <option value="2">Semester 2</option>
                    <option value="3">Semester 3</option>
                    <option value="4">Semester 4</option>
                    <option value="5">Semester 5</option>
                    <option value="6">Semester 6</option>
                </select>
            </div>
            
                <div class ="input-group">

     

                    <?php if($edit_state == false):?>
                   
                       

                    <button type="submit" name="save" class="btn">Save</button>
                    
                 
                    
                    <?php else:?>
                   
                        <button type="submit" name="update" class="btn">Update</button>
                    <?php endif ?>
                </div>
            </form>
</body>
</html>