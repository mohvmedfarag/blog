<?php 
  require_once 'inc/connection.php';
  require_once 'inc/header.php';
  ?>

    <!-- Page Content -->
    <div class="page-heading products-heading header-text">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="text-content">
              <h4>View Post</h4>
              <h2>View personal post</h2>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="best-features about-features">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
          <?php require_once 'inc/success.php' ?>

            <div class="section-heading">
              <h2>Our Background</h2>
            </div>
          </div>

          <?php 
          if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $query = "SELECT users.name, posts.* FROM posts join users 
              on posts.user_id = users.id
             where posts.id = $id";
            $runQuery = mysqli_query($conn, $query);

              if (mysqli_num_rows($runQuery) == 1) {
                $post = mysqli_fetch_assoc($runQuery);
              } else {
                $_SESSION['errors'] = ['post not found'];
                header('Location:index.php');
              }
    
          } else {
            $_SESSION['errors'] = ['post not found'];
            header('Location:index.php');
          }
          
          ?>

          <div class="col-md-6">
            <div class="right-image">
              <img src="uploads/<?= $post['image'] ?>" alt="">
            </div>
          </div>
          <div class="col-md-6">
            <div class="left-content">
              <h4><?= $post['title'] ?></h4>
              <p><?= $post['body'] ?></p>
              
              <?php 
              if(isset($_SESSION['user_id'])){ ?>
              <h4>Created by : <?= $post['name'] ?></h4>
              <div class="d-flex justify-content-center">
                  <a href="editPost.php?id=<?= $id ?>" class="btn btn-success mr-3 "> edit post</a>
              
                  <form action="handle/deletePost.php?id=<?= $id ?>" method="post">
                    <button type="submit" class="btn btn-danger" name="submit" onclick="alert('are you sure')">Delete</button>
                  </form>
                
              </div>
              <?php
              }
              ?>
            </div>
          </div>

        </div>
      </div>
</div>

    <?php require_once 'inc/footer.php' ?>
