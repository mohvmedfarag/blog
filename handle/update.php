<?php
require_once '../inc/connection.php';


if (isset($_POST['submit']) && isset($_GET['id'])) {
    
    $id = $_GET['id'];

    $query = "select * from posts where id = $id";

    $runQuery = mysqli_query($conn, $query);

    if (mysqli_num_rows($runQuery) == 1) {
        $oldImageName = mysqli_fetch_assoc($runQuery)['image'];
        $title = trim(htmlspecialchars($_POST['title']));
        $body = trim(htmlspecialchars($_POST['body']));

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



            if (!empty($_FILES['image']['name'])) {
                $image = $_FILES['image'];
                $imageName = $image['name'];
                $tmpName = $image['tmp_name'];
                $size = $image['size'] / (1024*1024);
                $ext = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));
                $error = $image['error'];

                $arr =['png', 'jpg', 'jpeg', 'PNG', 'JPEG', 'JPG'];
                if ($error != 0){
                    $errors[] = "image not correct";
                }else if(!in_array($ext,$arr)){
                    $errors[] = "choose correct image";
                }else if( $size > 2 ){
                    $errors[] = "image is large";
                }
                $newImageName = uniqid() . "." . $ext;
            } else {
                $newImageName = $oldImageName;
            }
            
            if (empty($errors)){
                $query = "update posts set `title` = '$title' , `body` = '$body' , `image` = '$newImageName' where id = $id";
                $runQuery = mysqli_query($conn , $query);

                if ($runQuery) {
                    if (!empty($_FILES['image']['name'])) {
                        unlink("../uploads/$oldImageName");
                        move_uploaded_file($tmpName, "../uploads/$newImageName");
                    }
                    $_SESSION['success'] = "post updating successfully";
                    header("location: ../viewPost.php?id=$id");
                }else{
                    $_SESSION['errors'] =['error while updating'];
                    header("location: ../editPost.php?id=$id");
                }

            } else {
                $_SESSION['errors'] =$errors;
                header("location: ../editPost.php?id=$id");
            }
            

    } else {
        $_SESSION['errors'] = ['post not found'];
        header("location: ../index.php");
    }
    

} else {
    header("location: ../index.php");
}
