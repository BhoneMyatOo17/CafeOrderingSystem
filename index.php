<!DOCTYPE html>
<?php session_start();
include ('connections.php'); 
include('dbconnect.php');?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>The Urban Brew: Welcome to our Cafe</title>
    <meta name="description" content="Restaurant">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- External CSS -->
    <link rel="stylesheet" href="/urbanbrew/vendor/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="/urbanbrew/vendor/select2/select2.min.css">
    <link rel="stylesheet" href="/urbanbrew/vendor/owlcarousel/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdn.rawgit.com/noelboss/featherlight/1.7.13/release/featherlight.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/css/tempusdominus-bootstrap-4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.1/css/brands.css">

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700|Josefin+Sans:300,400,700">
    <link rel="stylesheet" href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">

    <!-- CSS -->
    <link rel="stylesheet" href="/urbanbrew/css/style.min.css">

    <!-- Modernizr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.js"></script>
    <style type="text/css">
        .ccolor{
        background-color: #F34949 !important;
    }
         .menu-card {
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        .menu-card img {
            height: 200px;
            object-fit: cover;
            width: 100%;
        }
        .menu-desc {
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        .menu-description {
            flex: 1;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
        }
    </style>
</head>

<body data-spy="scroll" class="static-layout">
    <?php include('navigation.php'); ?>

    <div id="side-nav" class="sidenav">
    <a href="javascript:void(0)" id="side-nav-close">&times;</a>
    
</div>
    <div id="side-search" class="sidenav">
    <a href="javascript:void(0)" id="side-search-close">&times;</a>
    <div class="sidenav-content">
        <form action="">
            <div class="input-group md-form form-sm form-2 pl-0">
              <input class="form-control my-0 py-1 red-border" type="text" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="input-group-text red lighten-3" id="basic-text1">
                    <i class="fas fa-search text-grey" aria-hidden="true"></i>
                </button>
              </div>
            </div>
        </form>
    </div>
</div>
    <div id="canvas-overlay"></div>
    <div class="boxed-page">
        <!-- Hero Section -->
        <div class="hero">
          <div class="container">
            <div class="row d-flex align-items-center">
                <div class="col-lg-6 hero-left">
                    <h1 class="display-4 mb-5">We Love <br>Delicious Foods!</h1>
                    <div class="mb-2">
                        <a class="btn btn-primary btn-shadow btn-lg ccolor" href="menu2.php" role="button">Explore Menu</a>
                    </div>
                   
                    <ul class="hero-info list-unstyled d-flex text-center mb-0">
                    <li class="border-right">
                        <span class="lnr lnr-leaf"></span>
                        <h5>Fresh Food</h5>
                    </li>
                        <li class="border-right">
                            <span class="lnr lnr-rocket"></span>
                            <h5>Fast Delivery</h5>
                        </li>
                        <li class="">
                            <span class="lnr lnr-bubble"></span>
                            <h5>24/7 Support</h5>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-6 hero-right">
                    <div class="owl-carousel owl-theme hero-carousel">
                    <div class="item">
                        <img class="img-fluid" src="img/coffee/latte.png" alt="">
                    </div>
                    <div class="item">
                        <img class="img-fluid" src="img/coffee/affogato.png" alt="">
                    </div>
                    <div class="item">
                        <img class="img-fluid" src="img/smoothies/avocado.png" alt="">
                    </div>
                </div>
                </div>
            </div>
          </div>
        </div>

        <!-- Menu Items Section -->
        <section id="gtco-menu-items" class="bg-white section-padding">
            <div class="container">
                <div class="section-content">
                    <div class="heading-section text-center">
                        <span class="subheading">
                            Our Menu
                        </span>
                        <h2>
                            Delicious Offerings
                        </h2>
                    </div>
                    
                    <div class="menu-category mb-5">
                        <div class="heading-menu text-center">
                            <h3 class="mb-5">✦. ── Coffee ── .✦</h3>
                        </div>
                        <div class="row">
                            <?php
                            $query= "SELECT * FROM Product p, ProductType pt WHERE p.ProductTypeID = pt.ProductTypeID AND pt.ProductTypeID = '1' ORDER BY ProductID DESC";
                            $ret= mysqli_query($connection, $query);
                            $count=mysqli_num_rows($ret);
                            if ($count==0) {
                                echo "<p class='text-center w-100'>No items found in this category.</p>";
                            } else {
                                for($a=0; $a <$count; $a+=4) {
                                    $query1= "SELECT * FROM Product p, ProductType pt WHERE p.ProductTypeID = pt.ProductTypeID AND pt.ProductTypeID = '1' ORDER BY ProductID LIMIT $a,4";
                                    $ret1= mysqli_query($connection,$query1);
                                    $count2=mysqli_num_rows($ret1);
                                    
                                    echo "<div class='row mb-4'>";
                                    
                                    for ($i=0; $i < $count2; $i++) {
                                        $data=mysqli_fetch_array($ret1);
                                        $Product_ID=$data['ProductID'];
                                        $Product_Name=$data['ProductName'];
                                        $Product_Amount=$data['ProductPrice'];
                                        $Product_Description=$data['ProductDescription'];
                                        $image=$data['ProductImage'];
                            ?>
                            <div class="col-lg-3 col-md-6 menu-item mb-4">
                                <div class="menu-card shadow h-100">
                                    <img src="<?php echo $image ?>" class="img-fluid" alt="<?php echo $Product_Name ?>">
                                    <div class="menu-desc p-4">
                                        <h4><?php echo $Product_Name ?></h4>
                                        <p class="price text-muted">£ <?php echo $Product_Amount ?></p>
                                        <p class="menu-description"><?php echo substr($Product_Description, 0, 80) ?>...</p>
                                        <a href="menudetails.php?ProductID=<?php echo $Product_ID ?>" class="btn btn-primary btn-sm mt-auto">Order</a>
                                    </div>
                                </div>
                            </div>
                            <?php   
                                    }
                                    echo "</div>";
                                }
                            }
                            ?>
                        </div>
                    </div>
                    <hr>
                    
                    <div class="menuitems mt-5">
                        <div class="heading-section text-center">
                            <span class="subheading">
                                Specialties
                            </span>
                            <h2>
                                Thai Special
                            </h2>
                        </div>
                        <div class="menu-category mb-5">
                        <div class="heading-menu text-center">
                            <h3 class="mb-5">✦. ── Thai Dishes ── .✦</h3>
                        </div>
                        <div class="row">
                            <?php
                            $query= "SELECT * FROM Product p, ProductType pt WHERE p.ProductTypeID = pt.ProductTypeID AND pt.ProductTypeID = '1' ORDER BY ProductID DESC";
                            $ret= mysqli_query($connection, $query);
                            $count=mysqli_num_rows($ret);
                            if ($count==0) {
                                echo "<p class='text-center w-100'>No items found in this category.</p>";
                            } else {
                                for($a=0; $a <$count; $a+=4) {
                                    $query1= "SELECT * FROM Product p, ProductType pt WHERE p.ProductTypeID = pt.ProductTypeID AND pt.ProductTypeID = '6' ORDER BY ProductID LIMIT $a,4";
                                    $ret1= mysqli_query($connection,$query1);
                                    $count2=mysqli_num_rows($ret1);
                                    
                                    echo "<div class='row mb-4'>";
                                    
                                    for ($i=0; $i < $count2; $i++) {
                                        $data=mysqli_fetch_array($ret1);
                                        $Product_ID=$data['ProductID'];
                                        $Product_Name=$data['ProductName'];
                                        $Product_Amount=$data['ProductPrice'];
                                        $Product_Description=$data['ProductDescription'];
                                        $image=$data['ProductImage'];
                            ?>
                            <div class="col-lg-3 col-md-6 menu-item mb-4">
                                <div class="menu-card shadow h-100">
                                    <img src="<?php echo $image ?>" class="img-fluid" alt="<?php echo $Product_Name ?>">
                                    <div class="menu-desc p-4">
                                        <h4><?php echo $Product_Name ?></h4>
                                        <p class="price text-muted">£ <?php echo $Product_Amount ?></p>
                                        <p class="menu-description"><?php echo substr($Product_Description, 0, 80) ?>...</p>
                                        <a href="menudetails.php?ProductID=<?php echo $Product_ID ?>" class="btn btn-primary btn-sm mt-auto">Order</a>
                                    </div>
                                </div>
                            </div>
                            <?php   
                                    }
                                    echo "</div>";
                                }
                            }
                            ?>
                        </div>
                    </div>
                    <hr>
                </div>
            </div>
        </section>
</div>
</div>
        <!-- Footer -->
        <?php include('footer.php'); ?>
    


    <!-- External JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
    <script src="vendor/bootstrap/popper.min.js"></script>
    <script src="vendor/bootstrap/bootstrap.min.js"></script>
    <script src="vendor/select2/select2.min.js "></script>
    <script src="vendor/owlcarousel/owl.carousel.min.js"></script>
    <script src="https://cdn.rawgit.com/noelboss/featherlight/1.7.13/release/featherlight.min.js"></script>
    <script src="vendor/stellar/jquery.stellar.js" type="text/javascript" charset="utf-8"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Main JS -->
    <script src="js/app.min.js "></script>
</body>
</html>