<?php
require_once '../../inc/connection.php';

// submit catch validation hash insert login

if(isset($_POST['submit'])){

    // catch
    $name = trim(htmlspecialchars($_POST['name']));
    $email = trim(htmlspecialchars($_POST['email']));
    $password = trim(htmlspecialchars($_POST['password']));
    $phone = trim(htmlspecialchars($_POST['phone']));

    // validation
    $errors = [];
    // first name ( required, string, 20char)
    if( $name == "" ){
        $errors[] = "name is required";
    }else if(!preg_match('/^[a-zA-Z]+$/', $name)){
        $errors[] = "Digits are not allowed";
    }else if( strlen($name) < 5 ){
        $errors[] = "name must be greater than 5 characters";
    };

    // email ( required, email, length)
    if( $email == "" ){
        $errors[] = "email is required";
    }else if(! filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errors[] = "invalid email address";
    }

    if( $phone == "" and !preg_match("/^[0-9]+$/", $phone)){
        $errors[] = "the phone number must be a number";
    }

    if( $password == "" ){
        $errors[] = "password is required";
    }else if(strlen($password) < 5){
        $errors[] = "password must be greater than 5 characters";
    }
    
    if(empty($errors)){
        
        // hash
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        
        // insert
        $query = "insert into users(`name`, `email`, `password`, `phone`) values('$name', '$email', '$passwordHash', '$phone')";
        $runQuery = mysqli_query($conn, $query);

        if ($runQuery) {
            $_SESSION['success'] = "admin creating successfully";
            header("Location:../../Login.php");
        } else {
            header("Location: ../register.php");
        }
        
    }else{
        $_SESSION['errors'] = $errors;
        header("Location: ../register.php");
    }
}else {
    header("location: ../register.php");
}

?>