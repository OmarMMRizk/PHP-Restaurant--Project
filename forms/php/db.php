<?php


$host = 'localhost';
$dbname = 'resturant';
$username = 'root';
$password = 'Password@123';
$pdo;
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Enable exceptions for errors
} catch (PDOException $e) {
}



function add_review($user_id, $rating, $review){
    global $pdo;
    $add_review_stmt = $pdo->prepare("INSERT INTO reviews (user_id, rating, review) VALUES (:user_id, :rating, :review)");

    try {
        $add_review_stmt->execute(['user_id' => $user_id, 'rating' => $rating, 'review' => $review]); 
        return true;
    } catch (PDOException $e) {
    }
}
function get_reviews(){
    global $pdo;
    try {
        $stmt = $pdo->query("SELECT firstName, lastName, rating, review FROM reviews JOIN users ORDER BY reviews.created_at DESC LIMIT 5");
        $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);  
        return $reviews;
    } catch (PDOException $e) {
    }
}

function add_user($firstName, $LastName, $email, $password){
    global $pdo;
    $add_user_stmt = $pdo->prepare("INSERT INTO users (firstName, LastName, email, password) VALUES (:firstName, :LastName, :email, :password)");

    try {
        $add_user_stmt->execute(['firstName' => $firstName, 'LastName' => $LastName, 'email' => $email, 'password' => $password]); 
        return true;
    } catch (PDOException $e) {
    }
}

function delete_user($par,$val){
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM users WHERE $par = :val");
    try {
        $stmt->execute(['val' => $val]);
        return true;
    } catch (PDOException $e) {
    }

}
function fetch_user($par,$val){
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE $par = :val");
  
    try {
        $stmt->execute(['val' => $val]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC); 
    } catch (PDOException $e) {
    }

    if ($user) {
        return $user;
    } else {
    }
}
function validate_user($email,$password){
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email AND password = :password");
  
    try {
        $stmt->execute(['email' => $email,'password'=>$password]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC); 
    } catch (PDOException $e) {
        return false;
    }

    if ($user) {
        return $user;
    } else {
        return false;
    }
}

function fetch_all_users(){
    global $pdo;
    try {
        $stmt = $pdo->query("SELECT * FROM users");
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);  
        return $users;
    } catch (PDOException $e) {
    }



}

function update_user($par,$val,$id){
    global $pdo;
    $stmt = $pdo->prepare("UPDATE users SET $par = :val WHERE id = :id");
    try {
        $stmt->execute(['id' => $id, 'val'=>$val]);
        return true;
    } catch (PDOException $e) {
        return false;
    }

}


?>

