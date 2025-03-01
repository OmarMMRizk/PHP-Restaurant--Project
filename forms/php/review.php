<?php

require_once('hegazy_module.php');
session_start();
// get_reviews();
// Handle form submission

if(!$_SESSION['email']){header("Location:/forms/php/login.php");}
else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    add_review($_SESSION['id'],$_POST['rating'],$_POST['review']);
    header("Location:/forms/php/reviews.php");}
?>

<!DOCTYPE html>
<html>
<head>
<head>
    <link rel="stylesheet" href="/forms/styles/style.css">
</head>
<body>
        <form method="post" class="hegazy-form" style="scale:1.5">
            <div class="c">
                <h1>Write a Review</h1>
                <hr>
            </div>
            <input type='rating' name='rating' stars=5 value=4 style="color:rgb(255, 100, 0);">

            <br>
            <textarea name="review" rows="4" placeholder="Write your review here" class='toValidate' validation_required='Required Field'></textarea>
            <button type="submit">Submit Review</button>
        </form>
        <script>initialize()</script>
   
</body>
</html>