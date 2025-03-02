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
          case 'email':
            $check=filter_var($value, FILTER_VALIDATE_EMAIL);
            if(!$check||!preg_match('/^[\w_\.]+@([\w-]+\.)+[\w]{2,4}$/', $value)){$errors[$key]="Invalid Email !";};
           break;

          default:
          ;
          
        };  
    };   


};
$sent=false;
if(!count($errors)&&count($_POST)){
    $user=fetch_user('email',$_POST['email']);
    if(!$user){
        global $errors;
        $errors['email']="Email is not registered";
    }
    else{
    if(
        update_user('password_reset',1,$user['id'])
        &&email($user['first_name'] ." ". $user['lastName'],$user['email'], 'Reset Your Password', "http://localhost:8080/forms/php/password.php")

    )  {
        $sent=true;
    }
    else{echo "<h1 style='color:red;text-align:center;text-shadow:0px 0px .1em black'>Failure !</h1>";}     
    }
 

}

?>



<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="/forms/styles/style.css">

</head>

<body>

    <form class="hegazy-form" method="post" action="/forms/php/reset.php" novalidate>
        <div class="c">
            <h1>Recovery</h1>
            <hr>
        </div>
        <?php
        if(!$sent){
            echo "<div>
                <label for='email'>Email</label>
                <input class='toValidate' type='email' validation_required='Required Field' validation_pattern='^[\w_\.]+@([\w-]+\.)+[\w]{2,4}$' validation_message='Invalid Email Format' name='email' id='email' placeholder='Email Address'>
                </div>
                <div class='c'>
                <button type='submit'>Send Request</button>
                <hr>
                </div>
                ";
            }else{
                echo "<div class='c'>
                <h2 style='color:green;'>Password reset request was sent your email</h2>
                </div>
                ";
            }
        ?>



        <div class="c">
            <a href="/forms/php/login.php">Log In</a>

        </div>
        <div class="c">
            <a href="/forms/php/register.php">Create a new account</a>
        </div>
    </form>

    <script>initialize();invalidate_all(<?=json_encode($errors); ?>,<?=json_encode($_POST);?>)</script>
</body>

</html>
