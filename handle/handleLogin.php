<?php
require_once '../inc/connection.php';

 if (!isset($_SESSION['user_id'])) {
    header('Location: Login.php');
 }
 

// submit catch validation hash insert login

if(isset($_POST['submit'])){

    // catch
   
    $email = trim(htmlspecialchars($_POST['email']));
    $password = trim(htmlspecialchars($_POST['password']));
   

    // validation
    $errors = [];
    // email ( required, email, length)
    if( $email == "" ){
        $errors[] = "email is required";
    }else if(! filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errors[] = "invalid email address";
    }

    if( $password == "" ){
        $errors[] = "password is required";
    }else if(strlen($password) < 5){
        $errors[] = "password must be greater than 5 characters";
    }

    if(empty($errors)){
        $query = "select * from users where email = '$email'";
        $runQuery = mysqli_query($conn , $query);
        if(mysqli_num_rows($runQuery) == 1){
            $user = mysqli_fetch_assoc($runQuery);
            $id = $user['id'];
            $name = $user['name'];
            $oldPassword = $user['password'];
            $verify = password_verify($password, $oldPassword);
            if($verify){
                $_SESSION['user_id'] = $id;
                $_SESSION['success'] = "welcome $name";
                header("Location: ../index.php");
            }else{
                $_SESSION['errors'] = ["user not found"];
                header("Location: ../Login.php");
            }
        }else{
            $_SESSION['errors'] = "user not found";
            header("Location: ../Login.php");
        }
    }else{
        $_SESSION['errors'] = $errors;
        header("Location: ../Login.php");
    }

}else{
    header("Location: ../Login.php");
}