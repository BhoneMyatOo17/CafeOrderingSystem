<?php 
session_start();
include('dbconnect.php');

if(!isset($_GET['TableID'])) {
    echo "<script>alert('Table Not Found'); window.history.back();</script>"; 
    exit();
}

$Table_ID = $_GET['TableID'];
$query = "SELECT * FROM Tables WHERE TableID = '$Table_ID'";
$result = mysqli_query($connection, $query);
$row = mysqli_fetch_array($result);
$Table_Name = $row['TableName'];
$Table_Capacity = $row['Capacity'];
$Table_Location = $row['TableLocation'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $Table_Name; ?> - The Urban Brew</title>
    <meta name="description" content="Table Details">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" href="img/weblogo.png">
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
        .move{
            padding: 25px;
        }
        .product-details-section {
            padding: 80px 0;
        }
        .product-card {
            background: white;
            border: 1.5px solid #e0e0e0;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            overflow: hidden;
            transition: all 0.3s ease;
        }
        .product-card:hover {
            box-shadow: 0 6px 16px rgba(0,0,0,0.15);
            transform: translateY(-2px);
        }
        .product-image-container {
            padding: 30px;
            text-align: center;
            border-right: 1.5px solid #e0e0e0;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .product-image-container img {
            max-width: 100%;
            max-height: 300px;
            width: auto;
            height: auto;
            border-radius: 5px;
            object-fit: contain;
        }
        .product-info-container {
            padding: 30px;
            display: flex;
            flex-direction: column;
        }
        .product-title {
            font-size: 1.8rem;
            margin-bottom: 1rem;
            color: #333;
            font-weight: 600;
        }
        .product-price {
            font-size: 1.5rem;
            color: #d65106;
            font-weight: 700;
            margin-bottom: 1.5rem;
        }
        .product-description {
            color: #666;
            line-height: 1.6;
            margin-bottom: 2rem;
        }
        .product-form {
            margin-top: auto;
        }
        .booking-date-control {
            margin-bottom: 1.5rem;
        }
        .booking-date-label {
            font-weight: 600;
            color: #555;
            display: block;
            margin-bottom: 8px;
        }
        .booking-date-input {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .btn-add-to-cart {
            background: #d65106;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 4px;
            font-weight: 600;
            transition: all 0.3s;
            width: 100%;
        }
        .btn-add-to-cart:hover {
            background: #b54505;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(214, 81, 6, 0.3);
        }

        @media (max-width: 768px) {
            .product-image-container {
                border-right: none;
                border-bottom: 1.5px solid #e0e0e0;
            }
            .product-title {
                font-size: 1.5rem;
            }
            .product-price {
                font-size: 1.3rem;
            }
        }
    </style>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.js"></script>
</head>
<body data-spy="scroll" class="static-layout">
    <?php include('navigation.php'); ?>
    <div id="side-nav" class="sidenav">
        <a href="javascript:void(0)" id="side-nav-close">&times;</a>
        <div class="sidenav-content">
            <p>Kuncen WB1, Wirobrajan 10010, DIY</p>
            <p><span class="fs-16 primary-color">(+68) 120034509</span></p>
            <p>info@yourdomain.com</p>
        </div>
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
        <!-- Table Details Section -->
        <section id="gtco-product-details" class="section-padding product-details-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 mx-auto">
                        <div class="product-card">
                            <div class="row no-gutters">
                                <div class="col-md-6 product-image-container">
                                    <img src="img/table-1.png" alt="<?php echo $Table_Name; ?>" class="img-fluid">
                                </div>
                                <div class="col-md-6 product-info-container">
                                    <div class="move">
                                    <h1 class="product-title"><?php echo $Table_Name; ?></h1>
                                    <div class="product-price">Capacity: <?php echo $Table_Capacity;?></div>
                                    <p class="product-description"><?php echo $Table_Location; ?></p>
                                    
                                    <form action="booking.php" method="POST" class="product-form">
                                        <input type="hidden" name="TableID" value="<?php echo $Table_ID; ?>">
                                        <input type="hidden" name="CustomerID" value="<?php echo $_SESSION['CustomerID'] ?? ''; ?>">
                                        
                                        <div class="booking-date-control">
                                            <label class="booking-date-label">Booking Date</label>
                                            <input type="date" name="BookingDate" class="booking-date-input" required 
                                                   min="<?php echo date('Y-m-d'); ?>">
                                        </div>
                                        
                                        <button type="submit" class="btn btn-primary btn-shadow btn-lg btn-add-to-cart">
                                            Book Now
                                        </button>
                                    </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
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
    
    <script>
        
        document.addEventListener("DOMContentLoaded", function() {
            var today = new Date().toISOString().split('T')[0];
            document.getElementsByName("BookingDate")[0].setAttribute('min', today);
        });
    </script>
</body>
</html>