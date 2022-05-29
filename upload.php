<?php
session_start();
// Include the database configuration file
require_once './core/Database.php';

$db = new Database;

$statusMsg = '';

// File upload path
$targetDir = "uploads/assignment_media/";
$fileName = basename($_FILES["file"]["name"]);
$targetFilePath = $targetDir . $fileName;
$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);




// $query = $db->pdo->prepare('SELECT course_id from courses where title =:t');
//         $query->bindParam(':t', $_POST['selectCourse']);
//         $query->execute();
//         $ctemp = $query->fetchAll();
//         $cres =$ctemp['0']['0'];
     
//         $course_id=$cres;

if(isset($_POST["submit"]) && !empty($_FILES["file"]["name"])){

         // Allow certain file formats
    $allowTypes = array('jpg','png','jpeg','gif','pdf');
    if(in_array($fileType, $allowTypes)){
        // Upload file to server
        if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){
            
        
            $query = $db->pdo->prepare('INSERT INTO student_assignment (student_id, title, description, semester, professor_assignment_id, file) VALUES (:student_id, :title, :description, :semester, :professor_assignment_id, :file)');
            $query->bindParam(':student_id', $_SESSION['user_id']);
            $query->bindParam(':title', $_POST['title']);
            $query->bindParam(':description', $_POST['description']);
            $query->bindParam(':semester', $_POST['selectSemester']);
            $query->bindParam(':professor_assignment_id', $_POST['selectAssignment']);
            $query->bindParam(':file', $fileName);

            $query->execute();
            if($query){
                $statusMsg = "The file ".$fileName. " has been uploaded successfully.";
            }else{
                $statusMsg = "File upload failed, please try again.";
            } 
        }else{
            $statusMsg = "Sorry, there was an error uploading your file.";
        }
    }else{
        $statusMsg = 'Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.';
    }

   
}else{
    $statusMsg = 'Please select a file to upload or there is already a file with that name';
}

// Display status message
$_SESSION['status_msg'] = $statusMsg;

header('Location: ./homework_upload.php');

?>
