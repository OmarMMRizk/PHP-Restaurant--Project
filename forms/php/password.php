<?php 
require_once("hegazy_module.php");

$errors=[];
session_start();

if($_SERVER["REQUEST_METHOD"] == "GET"&&$_GET['key']){
    if(validate($_GET['key'])){
        $_SESSION['password_key']=$_GET['key'];
    }
}

if(!$_SESSION['password_key']){
    header("Location:/forms/php/login.php"); 
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    foreach($_POST as $key=>$value){
        global $errors;
        $value=htmlspecialchars($value);
        $_POST[$key]=trim($value);
        
        switch($key){
          case empty($value):
            $errors[$key]="is Empty";
            break;
          case 'password':
            if(!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/', $value)){$errors[$key]="At least 8 characters containing a number, lower and upper case ones";}
            break;
          case 'confirmPassword':
            if($_POST[$key]!=$_POST['password']){$errors[$key]="Passwords don't match";}
            break;
  
          default:
          ;          
        };  
    };  
    echo "!!post!!";

    if(!count($errors)&&count($_POST)&&$_SESSION['password_key']){
        if(reset_password($_SESSION['password_key'],md5($_POST['password']))){
            $_SESSION['password_key']=false;
            header("refresh:5;url=/forms/php/login.php");
        }else{echo "<h1 style='color:red;text-align:center;text-shadow:0px 0px .1em black'>Error, try submitting another request !</h1>";}
    } 
};




?>


<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="/forms/styles/style.css">
</head>

<body>

    <form class="hegazy-form" method="post" action="/forms/php/password.php" novalidate>
        <div class="c">
            <h1>Reset Password</h1>
            <hr>
        </div>
    <?php
        if($_SESSION['password_key']){
            echo "<div>
                <label for='password'>New Password</label>
                <input id='password' class='toValidate' type='password' validation_required='Required Field' validation_pattern='^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$' validation_message='At least 8 characters containing a number, lower and upper case ones' name='password' placeholder='Password'>
            </div>

            <div>
                <label for='cpassword'>Confirm Password</label>
                <input id='cpassword' class='toValidate' type='password' validation_required='Required Field' validation_pattern='confirm password' validation_message='Password doesn't match' name='confirmPassword' placeholder='Confirm Password'>
            </div>

            <div class='c'>
                <button type='submit'>Change Password</button>
                <hr>
            </div>

            <div class='c'>
            <a href='/forms/php/login.php'>Log In</a>
            </div>

            <div class='c'>
                <a href='/forms/php/register.php'>Create a new account</a>
            </div>
            ";
            
        }else{echo "<div class='c'>
            <h2 style='color:green;'>Password reset successfully, redirecting to the log in screen</h2>
        </div>";}
    ?>
        

    </form>

    <script src="/forms/validation.js"></script>
    <script>initialize();invalidate_all(<?=json_encode($errors); ?>,<?=json_encode($_POST);?>)</script>
</body>

</html>
