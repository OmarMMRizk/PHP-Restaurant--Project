<?php 
require_once("hegazy_module.php");


session_start();


$skip=true;
if($_SERVER["REQUEST_METHOD"] == "GET"){
    if($_GET['logout']){logout();}
    else if($_GET['key']){
        if(validate($_GET['key'])){
            echo $_GET['key'];
           $_SESSION['confirmed']=true;
           $skip=false;
        }
    }
}

$text="Please, check your email to confirm your account !";
$logText="Log Out";
$href="/forms/php/confirm.php?logout=true";
$home="/forms/php/home.php";
if($_SESSION['confirmed']){
    $logText="Log In";
    $text="Email Confirmed Successfully";
    if($_SESSION['email']){
        $logText="Redirecting...";
        $href=$home;
        if($skip){header("Location:$home");}else{ header("refresh:5;url=$home");}
       
    }
}

else if(!$_SESSION['email']){
    header("Location:/forms/php/login.php");
}

if($_SERVER["REQUEST_METHOD"]=="POST" && $_POST['resend']=true){
    $_POST['resend']=false;
    $user=fetch_user('email',$_SESSION['email']);
    email($user['firstName'] ." ". $user['lastName'],$user['email'],'Confirm Your Email',"http://localhost:8080/forms/php/confirm.php");
    $_SESSION['resend_confirmation']=true;
}

if($_SESSION['resend_confirmation']){$resend_text='Confirmation Resent';}
else{$resend_text='Resend Confirmation';}

?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="/forms/styles/style.css">
</head>

<body>

    <form class="hegazy-form" method="post" action="/forms/php/confirm.php" novalidate>
        <div class="c">
            <h1><?=$text?></h1>
            <hr>
        </div>
        <div class="c"></div>
        <div class="c">
            <input type='hidden' name='resend' value=true>
            <?php
                if(!$_SESSION['confirmed']){
                    if($_SESSION['resend_confirmation']){
                        echo "<button type='submit' disabled style='color:white;background-color:green;'>$resend_text</button>";
                    }else{echo "<button type='submit'>$resend_text</button>";}
                }
            ?>
        </div>
        <div class="c">
            <a href=<?=$href?>><?=$logText?></a>
        </div>
    </form>

    <script>initialize();invalidate_all(<?=json_encode($errors); ?>,<?=json_encode($_POST);?>)</script>
</body>

</html>
