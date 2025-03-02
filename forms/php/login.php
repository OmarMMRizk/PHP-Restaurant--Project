<?php 
require_once("../../backend/modules/module.php");

$errors=[];
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if($_GET['success']){
        echo "<h1 style='color:green;text-align:center;text-shadow:0px 0px .1em black;margin:auto;'>Registered successfully, please check your email for the confirmation message !</h1>";
    }
}
else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    foreach($_POST as $key=>$value){
        global $errors;
        $value=htmlspecialchars($value);
        $_POST[$key]=trim($value);

        switch($key){
          case empty($value):
            $errors[$key]="is Empty";
            break;
          case 'email':
            $check=filter_var($value, FILTER_VALIDATE_EMAIL);
            if(!$check||!preg_match('/^[\w_\.]+@([\w-]+\.)+[\w]{2,4}$/', $value)){$errors[$key]="Invalid Email !";};
            break;
          case 'password':
            if(!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/', $value)){$errors[$key]="At least 8 characters containing a number, lower and upper case ones";}
            break;
  
          default:
          ;
          
        };  
    };   
    if(!count($errors)&&count($_POST)){

        $_POST['password']=md5($_POST['password']);
        $validate=validate_user($_POST['email'],$_POST['password']);
    
    
        if($validate){
            session_start();
            $_SESSION['email'] = $_POST['email'];
            $_SESSION['confirmed'] = $validate['confirmed'];
            $_SESSION['id']=$validate['id'];
            redirect("/forms/php/confirm.php");
        }else{echo "<h1 style='color:red;text-align:center;text-shadow:0px 0px .1em black'>Invalid Credentials !</h1>";}
    }
    

};



?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="/forms/styles/style.css">

</head>

<body>

    <form class="hegazy-form" method="post" action="/forms/php/login.php" novalidate>
        <div class="c">
            <h1>Log In</h1>
            <hr>
        </div>
        <div>
            <label for='email'>Email</label>
            <input class="toValidate" type="email" validation_required="Required Field" validation_pattern="^[\w_\.]+@([\w-]+\.)+[\w]{2,4}$" validation_message="Invalid Email Format" name="email" id='email' placeholder="Email Address">
        </div>
        <div>
            <label for='password'>Password</label>
            <input class="toValidate" type="password" validation_required="Required Field" validation_pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$" validation_message="At least 8 characters containing a number, lower and upper case ones" name="password" id='password' placeholder="Password">
        </div>

        <div class="c">
            <button type="submit">Log In</button>
            <hr>
        </div>

        <div class="c">
            <a href="/forms/php/reset.php">Forgot your Password ?</a>

        </div>
        <div class="c">
            <a href="/forms/php/register.php">Create a New Account</a>
        </div>
    </form>

    <script>initialize();invalidate_all(<?=json_encode($errors); ?>,<?=json_encode($_POST);?>)</script>
</body>

</html>
