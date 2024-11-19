<?php 

require_once '../inc/connection.php';
require_once '../inc/header.php';


 if (!isset($_SESSION['user_id'])) {
    header('Location: Login.php');
 }else{
    $user_id = $_SESSION['user_id'];
    if (isset($_POST['submit']) and $_SERVER['REQUEST_METHOD'] == 'POST') {
        
        // catch
        $title = trim(htmlspecialchars($_POST['title']));
        $body = trim(htmlspecialchars($_POST['body']));
        $image = $_FILES['image'];

        $imageName = $image['name'];
        $tmpName = $image['tmp_name'];
        $size = $image['size'] / (1024*1024);
        $ext = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));
        $error = $image['error'];
        $newImageName = uniqid() . "." . $ext;

        // validation
        $errors = [];

        if($title == ''){
            $errors[] = 'title is required';
        }else if(is_numeric($title)){
            $errors[] = 'title must be string';
        }

        if($body == ''){
            $errors[] = 'body is required';
        }else if(is_numeric($body)){
            $errors[] = 'body must be string';
        }

        $ext_array = [ 'jpg' , 'jpeg' , 'png'];
        if( $error != 0 ){
            $errors[] = 'image is required';
        }else if (! in_array($ext, $ext_array)){
            $errors[] = 'image not valid';
        }else if( $size > 2){
            $errors[] = 'image is too large';
        }

        // store
        if (empty($errors)) {
            $query = "insert into posts (`title`, `body`, `image`, `user_id`) values('$title', '$body', '$newImageName', $user_id)";
            $runQuery = mysqli_query($conn, $query);
            if ($runQuery) {
                move_uploaded_file($tmpName, "../uploads/$newImageName");
                $_SESSION['success'] = "Post created successfully";
                header('Location: ../index.php');
            } else {
                $_SESSION['errors'] = "error while creating";
                header('Location: ../addPost.php');
            }
            
        } else {
            $_SESSION['errors'] = $errors;
            $_SESSION['title'] = $title;
            $_SESSION['body'] = $body;
            header('Location: ../addPost.php');
        }
        

    } else {
        header('Location: ../addPost.php');
    }
 }



?>