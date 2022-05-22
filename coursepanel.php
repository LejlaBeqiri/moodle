<?php include('includes/current_page.php');?>
<?php
    session_start();
//     if(!isset($_SESSION['email']) || $_SESSION['is_admin']==0){
//         header("Location: ./index.php");

//    }
?>

<?php 
    $edit_state = false;
    require './controllers/Course/CourseController.php';
    
    $course = new CourseController;
    $db = mysqli_connect('localhost','root','','dnotes');
    $results = mysqli_query($db,"SELECT * FROM courses");
    $category_results = mysqli_query($db,"SELECT * FROM category");
    $course_id =0;

    
    if(isset($_POST['save'])){
        $course->store($_POST);
        header('Location: ./coursespanel.php');
    }
    if(isset($_GET['del'])){
        $course->destroy($_GET["del"]);
        header('Location: ./coursespanel.php');
    }

    //course_id qe fitohet prej edit butonit, perdoret prej metodes update($course_id,$_POST)
    if(isset($_GET['edit'])){
        $course_id = $_GET['edit'];
        $title= $_GET['title'];
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
         
        <link rel="stylesheet" type="text/css" href="css/styleadminpannel.css">
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">

    </head>
<body>


    <?php include('includes/dashboard_navigation.php');?>
        <table>
            <thead>
                <tr>
                    <th style = "font-size:25px">Course</th>
                    <th style = "font-size:25px">Category</th>                    
                    <th class ="actionclass" colspan = "2">Action</th>
                </tr>
            </thead>
            <tbody>