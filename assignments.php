<?php
    include('./includes/header.php');
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
    if(isset($_SESSION['role']) && $_SESSION['role']==2){
        header("Location: ./index.php");
    }

    $assignment_id='';
    $title= '';
    $description = '';
    $due = '';
    $edit_state = false;
    require './controllers/Assignment/AssignmentController.php';

    
    $asm = new AssignmentController;
    $course_id =0;

    
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
        <?php foreach($asm->all($_SESSION['user_id']) as $row ){ ?>
            <tr>
            <td><?php echo $row['title'] ?></td>
            <td>
                <?php 
                   echo $row['description'];
                ?>
            </td>
            <td>
            <?php 
                echo $row['name'];       
            ?>
            </td>
            <td>
                <?php echo $row['due'];?>
            </td>
            <td class ="editclass">
                <a class ="edit_btn" href="assignments.php?edit=<?php echo $row['id']; ?>&title=<?php echo $row['title']?>&description=<?php echo $row['description'] ?> &due=<?php echo $row['due'] ?>">Edit</a>
            </td>   
            <td class ="updateclass">
            <a class ="del_btn" href="assignments.php?del=<?php echo $row['id']; ?>">Delete</a>
            </td>

        </tr>
        <?php } ?>
        
    </tbody>
    </table>
    <form method="post" action ="">

            <input type ="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">


            <div class ="input-group">
                <label>Assignment Title</label>
                <input type="text" value="<?php echo $title; ?>" name="title">

                <label> Description</label>
                <input type="text" value="<?php echo $description; ?>" name="description">

                <label>Course</label>
                <select name = "selectCourse">
                        <?php foreach($asm->courses() as $row ){ ?>
                            <option value="<?php echo $row['id'] ;?>"><?php echo $row['name']?></option>
                    
                        <?php } ?>
                </select>   
                <label>Due</label>
                <?php echo $due;?>
                <input type="datetime-local" value="<?php echo $due; ?>" name="due">
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