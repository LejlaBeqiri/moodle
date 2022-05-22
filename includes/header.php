<?php include('includes/current_page.php');

session_start();
?>



<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title?></title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">

    </head>
    <body>
    <div class="header">
        <div class="logo">
            
            <a href ="index.php"><img src="images/logo2.png"></a>
        </div>
        <div>
            <p style="color: #fb670e; font-size: 22px;">
                <?php if(isset($_SESSION['name'])){
                    echo 'Welcome ' . $_SESSION['name'];}
                    ?>
            </p>
        </div>
        <nav>
            <ul>
                <?php ?>

                <?php if(isset($_SESSION['role']) && $_SESSION['role']== 1 ){?>
     
                    <li><a href="courses.php">Courses</a></li>
                    <li><a href="assignments.php">Assignments</a></li>

                <?php }?>

                <?php if(isset($_SESSION['role']) && $_SESSION['role']== 2 ){?>
                    
                    <li><a href="index.php">Home</a></li>
                    <li><a href="courses.php">Courses</a></li>
                    <li><a href="homework.php">Homework</a></li>
                    <li><a href="upload.php">Upload</a></li>
                    <li><a href="profile.php">Profile</a></li>
                    <li><a href="faq.php">FAQ</a></li>
                <?php }?>

                <?php if(isset($_SESSION['is_admin']) && $_SESSION['is_admin']==1){?>
                    <li><a href="admindashboard.php">Dashboard</a></li>
                <?php }?>
                <?php if(isset($_SESSION['name'])){?>
                    <li><a class="button1" href="logout.php" type="submit" name="logout">Log Out</a></li>

                <?php  } else{?>
                <li><a  href="signup.php" name="upload">Sign Up</a></li>
                <li><a class="button1" href="signin.php">Sign in</a></li>
                <?php }?>
            </ul>
        </nav>
    </div>


    <?php
        
        //kodi qe e shfaq shiritin me emer t'faqes
        $home='/moodle/index.php';
        if($currentPage!=$home){
            include('includes/page_title.php');
        }
    
    ?>