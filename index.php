
<?php 
  require_once 'inc/connection.php';
  require_once 'inc/header.php';
 ?>
    <!-- Page Content -->
    <!-- Banner Starts Here -->
    <div class="banner header-text">
      <div class="owl-banner owl-carousel">
        <div class="banner-item-01">
          <div class="text-content">
            <!-- <h4>Best Offer</h4> -->
            <!-- <h2>New Arrivals On Sale</h2> -->
          </div>
        </div>
        <div class="banner-item-02">
          <div class="text-content">
            <!-- <h4>Flash Deals</h4> -->
            <!-- <h2>Get your best products</h2> -->
          </div>
        </div>
        <div class="banner-item-03">
          <div class="text-content">
            <!-- <h4>Last Minute</h4> -->
            <!-- <h2>Grab last minute deals</h2> -->
          </div>
        </div>
      </div>
    </div>
    <!-- Banner Ends Here -->

        <?php
        if(isset($_GET['page'])){
          $page = $_GET['page'];
        }else{
          $page = 1;
        }

        // limit 3 posts per page --> offset = (page - 1) * limit
        $limit = 3;
        $offset = ($page - 1) * $limit;
        // number of pages = total posts / limit
        $query = "select COUNT(id) as total from posts";
        $result = mysqli_query($conn, $query);
        if(mysqli_num_rows($result) ==1) {
          $totalPosts = mysqli_fetch_assoc($result)['total'];
        }
        $numberOFPages = ceil($totalPosts / $limit);

        if($page < 1) {
          header("Location:" .$_SERVER['PHP_SELF'] . "?page=1");
        }else if($page > $numberOFPages){
          header("Location:" .$_SERVER['PHP_SELF'] . "?page=$numberOFPages");
        }

            $query = "SELECT id, title, substring(body,1,70) as body, image, created_at FROM posts
            order by id limit $limit offset $offset";
            $runQuery = mysqli_query($conn , $query);

            if(mysqli_num_rows($runQuery) > 0){
              $posts = mysqli_fetch_all($runQuery, MYSQLI_ASSOC);
            }else{
              $msg = "No posts founded";
            }
          ?>

  
   <div class="latest-products">
      <div class="container">

      <?php require_once 'inc/success.php' ?>
      <?php require_once 'inc/errors.php' ?>   

        <div class="row">
          <div class="col-md-12">
            <div class="section-heading">
              <h2>Latest Posts</h2>
              <!-- <a href="products.html">view all products <i class="fa fa-angle-right"></i></a> -->
            </div>
          </div>


            <?php if (!empty($posts)) { 

                  foreach ($posts as $post){ ?>

                      <div class="col-md-4">
                        <div class="product-item">
                          <a href="#"><img src="uploads/<?= $post['image'] ?>" alt=""></a>
                          <div class="down-content">
                            <a href="#"><h4><?= $post['title'] ?></h4></a>
                            <h6><?= $post['created_at'] ?></h6>
                            <p><?= $post['body'] ?>.....etc</p>
                            <!-- <ul class="stars">
                              <li><i class="fa fa-star"></i></li>
                              <li><i class="fa fa-star"></i></li>
                              <li><i class="fa fa-star"></i></li>
                              <li><i class="fa fa-star"></i></li>
                              <li><i class="fa fa-star"></i></li>
                            </ul>
                            <span>Reviews (24)</span> -->
                            <div class="d-flex justify-content-end">
                              <a href="viewPost.php?id=<?= $post['id'] ?>" class="btn btn-info "> view</a>
                            </div>
                          </div>
                        </div>
                      </div>

                <?php  }
                
               } else { ?> <div class="alert alert-danger"><?= $msg ?></div> <?php
              } ?>
        </div>
      </div>
    </div>

    <div class="container d-flex justify-content-center">
        <nav aria-label="Page navigation example">
          <ul class="pagination">

            <li class="page-item <?php if($page == 1) echo "disabled" ?>">
              <a class="page-link" href=<?= $_SERVER['PHP_SELF']."?page=". $page-1 ?> aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
              </a>
            </li>

            <li class="page-item"><a class="page-link"><?= $page ." of ".$numberOFPages ?></a></li>
    
            <li class="page-item <?php if($page == $numberOFPages) echo "disabled" ?>">
              <a class="page-link" href=<?= $_SERVER['PHP_SELF']."?page=". $page+1 ?> aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
              </a>
            </li>
          </ul>
        </nav>
    </div>
<?php require_once 'inc/footer.php' ?>
