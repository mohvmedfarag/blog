<?php
require_once '../inc/connection.php';

 if (!isset($_SESSION['user_id'])) {
    header('Location: ../Login.php');
 }else{

    if (isset($_GET['id']) && isset($_POST['submit'])){

        $id = (int) $_GET['id'];

        $query = "select id from posts where id = $id";
        $runQuery = mysqli_query($conn, $query);

        if(mysqli_num_rows($runQuery) == 1){

            $post = mysqli_fetch_assoc($runQuery);
            if(! empty($post)){
                $image = $post['image'];
                unlink("../uploads/$image");
            }

            $query = "delete from posts where id = $id";
            $runQuery = mysqli_query($conn, $query);

            if($runQuery){
                $_SESSION['success'] = "Post deleted successfully";
                header("Location:../index.php");
            }else{
                $_SESSION['errors'] = ["error while deleting post"];
                header("Location:../index.php");
            }
        }else{
            $_SESSION['errors'] = ["post not found"];
            header("Location:../index.php");
        }

    }else{
        $_SESSION['errors'] = ["please choose correct action"];
        header("Location:../index.php");
    }
 }