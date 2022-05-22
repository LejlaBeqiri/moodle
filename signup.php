
<?php include('includes/current_page.php');?>

<?php
    
    require './controllers/Auth/AuthController.php';
    require './controllers/RoleController.php';
    $user = new AuthController;
    $roleController = new RoleController;

    $msg='';$msg2='';$msg3='';$msg4='';$msg5='';
    $name='';$email='';$password='';$repeatpassword='';
    $last_name=''; $role = '';

    if(isset($_POST['submitted'])){

        $username = $_POST['name'];
        $_POST['role'] = $_POST['selectRole'];
        $_POST['is_admin'] = 0;
        $email = $_POST['email'];
        $password = $_POST['password'];
        $repeatpassword = $_POST['repeat-pass'];

       //echo $username."</br>".$email."</br>".$password."</br>".$repeatpassword."</br>";
        if(empty($username)||empty($email)||empty($password)||empty($repeatpassword))
        {
            $msg5 = "<div class='signUperror'>Please fill all the required spaces !</div>";
        }
        elseif(strlen($username)<3)
        {
            $msg = "<div class='signUperror'>Username must contain atleast 3 characters !</div>";
        }
        elseif($user->emailExists($email))
        {
            $msg2 = "<div class='signUperror'>This email is already taken !</div>";
        }
        // elseif(strlen($password)<8)
        // {
        //     $msg3 = "<div class='signUperror'>Password must contain atleast 8 characters !</div>";
        // }
        elseif($password !== $repeatpassword)
        {
            $msg4 = "<div class='signUperror'>Password doesn't match !</div>";
        }
        else
        {
            $user->register($_POST);
            header('Location: ./signin.php');
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo $title?></title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script src="js/jquery-3.6.0.min.js"></script>
    <body>
    <div class="signIncontanier">

        <div class="loginBox">
            
            <article class="back">
                
                <img src="images/student.png" alt="User">
                
                <h3>Sign Up Here</h3>
                <?php echo $msg5; ?>
                <form class="signupForm" method="post">
                    <p>Enter First Name</p>
                    <input class="inp" type="text" name="name" value = '<?php echo $name; ?>'><br>
                    <?php echo $msg; ?>

                    <p>Enter Last Name</p>
                    <input class="inp" type="text" name="last_name" value = '<?php echo $last_name; ?>'><br>
                    <?php echo $msg; ?>

                    <p>Type Email</p>
                    <input class="inp" type="email" name="email"  value = '<?php echo $email; ?>' ><br>
                    <?php echo $msg2; ?>

                    <p>Select Role</p>
                    <select id="mySelectBox" name = "selectRole">
                        <?php foreach($roleController->all() as $row){ ?>
                            <option value="<?php echo $row['id'] ;?>"><?php echo $row['role_name']?></option>
                        <?php } ?>
                    </select>   

                    <p id="selectTitle">Enter Professor ID</p>
                    <input class="inp" type="email" name="email"  value = '<?php echo $email; ?>' ><br>
                    <?php echo $msg2; ?>

                    <p>Type Password</p>
                    <input class="inp" type="password" name="password" value = '<?php echo $password; ?>'><br>
                    <?php echo $msg3; ?>

                    <p>Confirm your Password</p>
                    <input class="inp" type="password" name="repeat-pass" value = '<?php echo $repeatpassword; ?>'><br>
                    <?php echo $msg4; ?>
                    <input class="subSignIN" type="submit" name="submitted" value="Sign Up">
                </form>
                    </article>
                </div>
            </div>
        </body>

        <script>
            var valueSelected= '';
            $('#mySelectBox').on('change', function (e) {
                var optionSelected = $("option:selected", this);
                valueSelected = this.value;
                if(valueSelected == 1){
                    $( "#selectTitle" ).text('Enter Professor ID');
                }
                else{
                    $( "#selectTitle" ).text('Enter Student ID');

                }
               
            });



            
        </script>

</html>

