<?php 
        if(isset($_SESSION['errors'])){ 
            foreach($_SESSION['errors'] as $error){ ?>
                <div class="alert alert-danger"> <?= $error ?> </div>
        <?php    }
       }
      unset($_SESSION['errors']);
?>

