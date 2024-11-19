<?php 
require_once 'connection.php';

if(isset($_GET['lang'])){
    $lang = $_GET['lang'];
}
if($lang == 'en'){
    $_SESSION['lang'] = 'en';
}else if($lang == 'ar'){
    $_SESSION['lang'] = 'ar';
}

header('Location:' . $_SERVER['HTTP_REFERER'])
?>