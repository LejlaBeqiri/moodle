<?php include('includes/current_page.php');?>

<?php

require './controllers/Auth/AuthController.php';

$user = new AuthController;
$msg ='';$msg2='';$msg3='';
$email='';$password='';

if(isset($_POST['submitted'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    if(empty($email)||empty($password))
    {
        $msg = "<div class='signUperror'>Please fill all the required spaces !</div>";
    }
    if(!($user->emailExists($email)))
    {
        $msg2 ="<div class='signUperror'>This email doesn't exists !</div>";
    }
    if($user->emailExists($email))
    {
        $pass = mysqli_query($db,"SELECT password FROM users WHERE email ='$email'");
        $pass_w = mysqli_fetch_array($pass);
        $dpass = $pass_w['password'];
        //$password = password_hash($password , PASSWORD_DEFAULT);
        if(!password_verify($password , $dpass))
        {
           $msg3 ="<div class='signUperror'>Password is incorrect !</div>";
        }else
        {
            $user->login($_POST);
            $_SESSION['email']=$_POST['email'];
        }
        
    }
}

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
    <div class="signIncontanier">

        <div class="loginBox">
            
            <article class="back">
                
                <img src="images/student.png" alt="User">
                
                <h3>Login Here</h3>
                <?php echo $msg; ?>
                <form class=""  method="POST">
                    <p>Type Email</p>
                    <input class="inp" type="email" name="email" ><br>
                    <?php echo $msg2; ?>
                    <p>Type Password</p>
                    <input class="inp" type="password" name="password"><br>
                    <?php echo $msg3; ?>
                    <!-- <a href="" class="he">Forgot your password ?</a><br/> -->
                    <a href="signup.php" class="he">Create an account ?</a><br/>
                    <input class="subSignIN" type="submit" name="submitted" value="Log In">

                </form>
            </article>
        </div>
      </div>
    </body>

</html>