<?php
 include('includes/current_page.php');

    if(isset($_SESSION['role']) && $_SESSION['role']==2){
        header("Location: ./index.php");

   }
?>

<?php 
    $name = '';
    $edit_state = false;
    require './controllers/Course/CourseController.php';

    
    $course = new CourseController;
    $course_id =0;

    
    if(isset($_POST['save'])){
        $course->store($_POST);
        header('Location: ./coursepanel.php');
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

    <form method="post" action ="">
            <input type ="hidden" name="selectProfessor" value="<?php echo $_SESSION['user_id']; ?>">
            <input type ="hidden" name="name" value="<?php echo $name; ?>">

            <div class ="input-group">
                <label>Course Title</label>
                <input required type="text" value="<?php echo $name; ?>" name="coursename">

                <label>Semester</label>
                <select required name = "selectSemester">
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