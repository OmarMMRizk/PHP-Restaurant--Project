<?php 
require_once('../../backend/modules/module.php');

$errors=[];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    foreach($_POST as $key=>$value){
        global $errors;
        $value=htmlspecialchars($value);
        $_POST[$key]=trim($value);

        switch($key){
          case empty($value):
            $errors[$key]="is Empty";
            break;
          case 'first_name':
          case 'last_name':
            if(!preg_match('/^[a-zA-Z]{3,}$/', $value)){$errors[$key]="At least 3 alphabetical characters required";};
            break;
          case 'email':
            $check=filter_var($value, FILTER_VALIDATE_EMAIL);
            if(!$check||!preg_match('/^[\w_\.]+@([\w-]+\.)+[\w]{2,4}$/', $value)){$errors[$key]="Invalid Email !";};
            break;
          case 'password':
            if(!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/', $value)){$errors[$key]="At least 8 characters containing a number, lower and upper case ones";}
            break;
          case 'confirmPassword':

            if($_POST[$key]!=$_POST['password']){$errors[$key]="Passwords don't match";}
  
          default:
          ;
          
        };  
    };   
};


if(!count($errors)&&count($_POST)){
    if(fetch_user('email',$_POST['email'])&&false==true){
        global $errors;
        $errors['email']="Email is already registered";
    }else{
        $_POST['password']=md5($_POST['password']);
        if(
            add_user($_POST['first_name'],$_POST['last_name'],$_POST['email'],$_POST['password'])
            &&email($_POST['first_name'] ." ". $_POST['last_name'],$_POST['email'],'Confirm Your Email',"http://localhost:8080/forms/php/confirm.php")
            ){
            redirect("/forms/php/login.php?success=true");
  
            

        }else{
            $errors['email']="Failed to send a confirmation email.";
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="/forms/styles/style.css">
</head>

<body>
    <br>
    <form class="hegazy-form" method="post" action="/forms/php/register.php" novalidate>
        <div class="c">
            <h1>Sign Up</h1>
            <hr>
        </div>
        <div>
            <label for='fname'>First Name</label>
            <input  class="toValidate"  validation_required="Required Field" validation_pattern="^[a-zA-z]{3,}$" validation_message="At least 3 alphabetical characters" name="first_name" id="fname" placeholder="Your First Name">
        </div>
        <div>
            <label for='lname'>Last Name</label>
            <input id='lname' class="toValidate"  validation_required="Required Field" validation_pattern="^[a-zA-z]{3,}$" validation_message="At least 3 alphabetical characters" name="last_name" placeholder="Your Last Name">
        </div>
        <div>
            <label for='email'>Email</label>
            <input id='email' class="toValidate" type="email" validation_required="Required Field" validation_pattern="^[\w_\.]+@([\w-]+\.)+[\w]{2,4}$" validation_message="Invalid Email Format" name="email" placeholder="Email Address">
        </div>
        <div>
            <label for='password'>Password</label>
            <input id='password' class="toValidate" type="password" validation_required="Required Field" validation_pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$" validation_message="At least 8 characters containing a number, lower and upper case ones" name="password" placeholder="Password">
        </div>
        <div>
             <label for='cpassword'>Confirm Password</label>
            <input id='cpassword' class="toValidate" type="password" validation_required="Required Field" validation_pattern="confirm password" validation_message="Password doesn't match" name="confirmPassword" placeholder="Confirm Password">
        </div>

        <div class="c">
            <button type="submit" style="">Sign Up</button>
            <hr>
        </div>

        <div class="c">
            <a href="/forms/recovery/recovery.html">Forgot your Password ?</a>

        </div>
        <div class="c">
            <a href="/forms/php/login.php">Alread have an account ?</a>
        </div>
    </form>
    <br>
    <script>initialize();invalidate_all(<?=json_encode($errors); ?>,<?=json_encode($_POST);?>)</script>
</body>

</html>
