<!DOCTYPE html>
<?php
session_start();
include('connections.php'); 
include ('dbconnect.php'); 
?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>The Urban Brew: Menu</title>
    <meta name="description" content="Restaurant Menu">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- External CSS -->
    <link rel="stylesheet" href="vendor/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="vendor/select2/select2.min.css">
    <link rel="stylesheet" href="vendor/owlcarousel/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdn.rawgit.com/noelboss/featherlight/1.7.13/release/featherlight.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/css/tempusdominus-bootstrap-4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.1/css/brands.css">

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700|Josefin+Sans:300,400,700">
    <link rel="stylesheet" href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
    
    <!-- CSS -->
    <link rel="stylesheet" href="css/style.min.css">
    <style>
        
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
        /* Search Form Styles */
    .search-form {
        max-width: 600px;
        margin: 0 auto;
        padding: 20px 0;
    }
    
    .search-container {
        position: relative;
        display: flex;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        overflow: hidden;
        transition: all 0.3s ease;
        border-radius: 30px; 
    }
    
    .search-container:hover {
        box-shadow: 0 8px 20px rgba(0,0,0,0.12);
    }
    
    .search-input {
        flex: 1;
        border-radius: 30px 0px 0px 30px;
        padding: 15px 25px;
        border: 1.5px solid #F34949;
        font-size: 1rem;
        font-family: 'Open Sans', sans-serif;
        color: #333;
        background: white;
    }
    
    .search-input:focus {
        outline: none;
        box-shadow: inset 0 0 0 1px #F34949;
    }
    
    .search-input::placeholder {
        color: #999;
    }
    
    .search-button {
        background: #F34949;
        color: white;
        border: none;
        padding: 0 25px;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
    }
   
    
    .search-button i {
        font-size: 1.2rem;
    }
    
    .sr-only {
        position: absolute;
        width: 1px;
        height: 1px;
        padding: 0;
        margin: -1px;
        overflow: hidden;
        clip: rect(0, 0, 0, 0);
        white-space: nowrap;
        border: 0;
    }
    
    @media (max-width: 768px) {
        .search-form {
            padding: 15px;
        }
        
        .search-input {
            padding: 12px 20px;
        }
        
        .search-button {
            padding: 0 20px;
        }
    }
    </style>

    <!-- Modernizr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.js"></script>
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
<?php 
if (isset($_SESSION['cid']) && $_SESSION['cid'] > 0) { 
    $customer_ID = $_SESSION['cid'];
    $query = "SELECT * FROM Customer WHERE CustomerID = '$customer_ID'";
    $ret = mysqli_query($connection, $query);
    $row = mysqli_fetch_array($ret);
    $user = $row['CustomerFirstName'];
} else {
    $user = '';
}
 ?>
    <div id="canvas-overlay"></div>
    <div class="boxed-page">
        <!-- Menu Section -->
        <section id="gtco-menu" class="section-padding">
            <div class="container">
                
                <div class="section-content">
                    <div class="heading-section text-center">
                        <h2 class="subheading">
                            Welcome <?php echo"$user"?><br>
                           ♡ Here's Our Menu ♡
                        </h2>
                        <span class="subheading">
                            Check out what we have to offer below
                        </span>
                       <form action="menusearch.php" method="POST" class="search-form">
    <div class="search-container">
        <input type="text" name="keyword" class="search-input" placeholder="Search our menu..." aria-label="Search" required>
        <button type="submit" name="search" class="search-button">
            <i class="fas fa-search"></i>
            <span class="sr-only">Search</span>
                    </button>
                </div>
            </form>
                       <hr>

                    </div>
                    
                    <!-- Food Category 1 -->
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
                    <!-- Thai Food -->
                    <div class="menu-category mb-5">
                        <div class="heading-menu text-center">
                            <h3 class="mb-5">✦. ── Thai ── .✦</h3>
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
                    <!-- Beverages Category -->
                    <div class="menu-category mb-5">
                        <div class="heading-menu text-center">
                            <h3 class="mb-5">✦. ── Smoothie ── .✦</h3>
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
                                    $query1= "SELECT * FROM Product p, ProductType pt WHERE p.ProductTypeID = pt.ProductTypeID AND pt.ProductTypeID = '2' ORDER BY ProductID LIMIT $a,4";
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
                    <!-- Soda -->
                    <div class="menu-category mb-5">
                        <div class="heading-menu text-center">
                            <h3 class="mb-5">✦. ── Soda ── .✦</h3>
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
                                    $query1= "SELECT * FROM Product p, ProductType pt WHERE p.ProductTypeID = pt.ProductTypeID AND pt.ProductTypeID = '3' ORDER BY ProductID LIMIT $a,4";
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
                    <!-- Juices -->
                    <div class="menu-category mb-5">
                        <div class="heading-menu text-center">
                            <h3 class="mb-5">✦. ── Juice ── .✦</h3>
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
                                    $query1= "SELECT * FROM Product p, ProductType pt WHERE p.ProductTypeID = pt.ProductTypeID AND pt.ProductTypeID = '4' ORDER BY ProductID LIMIT $a,4";
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
                    <!-- Pastries -->
                    <div class="menu-category mb-5">
                        <div class="heading-menu text-center">
                            <h3 class="mb-5">✦. ── Pastry ── .✦</h3>
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
                                    $query1= "SELECT * FROM Product p, ProductType pt WHERE p.ProductTypeID = pt.ProductTypeID AND pt.ProductTypeID = '5' ORDER BY ProductID LIMIT $a,4";
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
                    <!-- Sale Items -->
                    <!-- Juices -->
                    <div class="menu-category mb-5">
                        <div class="heading-menu text-center">
                            <h3 class="mb-5">✦. ── The Urban Brew exclusive items ── .✦</h3>
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
                                    $query1= "SELECT * FROM Product p, ProductType pt WHERE p.ProductTypeID = pt.ProductTypeID AND pt.ProductTypeID = '7' ORDER BY ProductID LIMIT $a,4";
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
        </section>

        <?php include('footer.php'); ?>
    </div>
</div>

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