<?php
 include('includes/current_page.php');
 include('./includes/header.php');
 if(!isset($_SESSION)) { 
        session_start(); 
    } 

if(isset($_SESSION['role']) && $_SESSION['role']==1){
    header("Location: ./index.php");
}
require './controllers/Homework/HomeworkController.php';

$hw = new Homework;


?>
 
<!DOCTYPE html>
<html>
    <head>
        <title>Upload</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
        <script src="./js/jquery-3.6.0.min.js"></script>

    </head>
    <body>


            <div class="signIncontanier-upload">

                <div class="loginBox-upload">
                    
                    <div class="back-upload">
                        
                        <img src="images/student3.png" alt="User">
                        
                        <h3>Your Profile</h3>
                        
                        <p><?php echo $_SESSION['email'];
                        ?></p>

                    </div>
                </div>

                <?php
                     if(isset($_SESSION['status_msg'])) { 
                        echo $_SESSION['status_msg'];
                    } 
                ?>
    
                <div class="uploadfilebox">
                <form class="uploadForm" action="upload.php" method="post" enctype="multipart/form-data">
                    <h1>Upload Your Homework Here</h1>
                    <label>User</label><br>
                    <input readonly class="input" type="text" value ="<?php echo $_SESSION['email'];?>"><br><br>
                    
                    <label>Assignment</label>
                    <select class="input" required name = "selectAssignment">
                            <?php
        
                            foreach($hw->all() as $row ){ ?>
                                <option value="<?php echo $row['id'] ;?>"><?php echo $row['title']?></option>
                        
                            <?php } ?>
                    </select>   
                    <label>Semester</label>
                    <select class="input" required name = "selectSemester">
                        <option value="1">Semester 1</option>
                        <option value="2">Semester 2</option>
                        <option value="3">Semester 3</option>
                        <option value="4">Semester 4</option>
                        <option value="5">Semester 5</option>
                        <option value="6">Semester 6</option>
                    </select>
          
                    
                    <label>Choose File</label><br>
                        <input class="input" type="file" name="file"><br>
                    <label>Title</label><br>
                        <input class="input" type="text" name="title"><br>
                        <textarea maxlength="500" name="description" class="uploaddescription"placeholder="Describe your work" ></textarea><br>
                    <button name="submit" class="submitupload-button" type="submit" value="submit">Submit</button>
                </form>

                
                </div>
            </div>

            <?php include('includes/footer.php');?>

    </body>

</html>