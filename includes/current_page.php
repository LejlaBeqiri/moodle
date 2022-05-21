<?php
    $currentPage=$_SERVER['REQUEST_URI'];
    $title='';
    switch ($currentPage) {
        case "/moodle/index.php":
            $title='Home';
            break;
        case "/moodle/courses.php":
            $title='Courses';
            break;
        case "/moodle/homework.php":
            $title='Homework';
        break;
        case "/moodle/grading.php":
            $title='Grading';
            break;
        case "/moodle/.php":
            $title='Sign In';
            break;
            case "/moodle/signup.php":
                $title='Sign Up';
            break;
        default:
            $title= "Moodle";
    }


?>