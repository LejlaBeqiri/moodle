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
    if(isset($_GET['del'])){
        $course->destroy($_GET["del"]);
        header('Location: ./coursepanel.php');
    }

    //course_id qe fitohet prej edit butonit, perdoret prej metodes update($course_id,$_POST)
    if(isset($_GET['edit'])){
        $course_id = $_GET['edit'];
        $name= $_GET['name'];
        $edit_state = true;
    }

    //permban kursin qe do te editohet
  
    $currentCourse = $course->edit($course_id);

  //$course_id id e rreshtit qe editohet
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


<?php include('includes/header.php');?>
<table>
    <thead>
        <tr>
            <th style = "font-size:25px">Course</th>
            <th style = "font-size:25px">Professor</th>                    
            <th style = "font-size:25px">Semester</th>                    
            <th class ="actionclass"  colspan= "2">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($course->allCourses() as $row ){ ?>
            <tr>
                <td><?php echo $row['name'] ?></td>
                <td>
                    <?php 
                    $prof = $course->professor($row['professor_id'])[0];
        
                    echo $prof['name'];

                    ?>
                </td>
                <td>
                <?php 
                    echo $row['semester'];       
                ?>
                </td>
                <td class ="editclass">
                    <a class ="edit_btn" href="course_assignments.php?id=<?php echo $row['id']; ?>&name=<?php echo $row['name']?>">View Assignments</a>
                </td>
  
            </tr>
        <?php } ?>
        
    </tbody>
    </table>

            </html>
</body>