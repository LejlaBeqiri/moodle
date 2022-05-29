<?php
 include('includes/current_page.php');

    if(isset($_SESSION['role']) && $_SESSION['role']==2){
        header("Location: ./index.php");

   }
?>

<?php 
    $name = '';
    $edit_state = false;
    require './controllers/Homework/HomeworkController.php';

    
    $hw = new Homework;

    
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
            <th style = "font-size:25px">File</th>                    
            <th style = "font-size:25px">Evaluated</th>                    
            <th class ="actionclass" >Action</th>
        </tr>
    </thead>
    <tbody>

        <?php foreach($hw->myHomework($_SESSION['user_id']) as $row ){ ?>
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
                        echo $row['file'];       
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
                     "target="_blank">View File</a>
                </td>

            </tr>
        <?php } ?>
        
    </tbody>
    </table>

</body>
</html>