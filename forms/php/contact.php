<?php 
require_once("../../backend/modules/module.php");

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
    if(    email_contact($_POST['email'], $_POST['subject'], $_POST['content'])
    ){
        $sent=true;
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
    <form class="hegazy-form" method="post" action="/forms/php/contact.php" novalidate>
        <div class="c">
            <h1>Contact Us</h1>
            <hr>
        </div>
        <?php
        if(!$sent){
            echo "
            <div>
            <label for='email'>Email</label>
            <input class='toValidate' type='email' validation_required='Required Field' validation_pattern='^[\w_\.]+@([\w-]+\.)+[\w]{2,4}$' validation_message='Invalid Email Format' name='email' id='email' placeholder='Email Address'>
        </div>
        <div>
            <label for='subject'>Subject</label>
            <input class='toValidate'  validation_required='Required Field'  name='subject' id='subject' placeholder='Subject'>
        </div>
        <div>
            <label for='content'>Content</label>
            <textarea class='toValidate' style='display:block;width:90%;font-size:150%;' name='content' id='content' validation_required='Required Field' rows='6' placeholder='Write Your Content'></textarea>
        </div>

        <div class='c'>
            <button type='submit'>Submit</button>
            <hr>
        </div>


            ";
        }
        else{
            echo "
                <div class='c'>
                    <h2 style='color:green'>Message sent Successfully !</h2>
                    <hr>
                </div>
            ";
        }
        ?>


        <div class='c'>
            <a href='/forms/php/home.html'>Back</a>
        </div>

    </form>
        <br>
    <script src="/forms/validation.js"></script>
    <script>initialize();invalidate_all(<?=json_encode($errors); ?>,<?=json_encode($_POST);?>)</script>
</body>

</html>
