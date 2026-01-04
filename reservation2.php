<?php session_start(); ?>
<!DOCTYPE html>
<?php 
include('connections.php'); 
include('dbconnect.php'); 
?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Table Reservation - The Urban Brew</title>
    <meta name="description" content="Reserve your table">
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
        .wrapper{
           height: 450vh;
        }
        .table-card {
            height: 100%;
            display: flex;
            flex-direction: column;
            border-radius: 4px;
            overflow: hidden;
        }
        .table-image {
            height: 200px;
            object-fit: cover;
            width: 100%;
            position: relative;
        }
        .table-number {
            position: absolute;
            top: 15px;
            left: 15px;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.9rem;
        }
        .table-details {
            padding: 1.5rem;
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        .table-info {
            margin-bottom: 0.5rem;
            color: #6c757d;
            font-size: 0.9rem;
        }
        .table-info i {
            margin-right: 8px;
            color: #495057;
        }
        .no-tables {
            text-align: center;
            padding: 40px;
            color: #6c757d;
            font-style: italic;
            width: 100%;
        }
    </style>
</head>
<body data-spy="scroll" class="static-layout">
    <div class="wrapper">
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
        <!-- Reservation Section -->
        <section id="gtco-reservation" class="section-padding">
            <div class="container">
                <div class="section-content">
                    <div class="heading-section text-center">
                        <h2 class="subheading">
                           ♡ Table Reservation ♡
                        </h2>
                        <span class="subheading">
                            Select your preferred table from our elegant dining options
                        </span>
                       <hr>
                    </div>
                    
                    <div class="row">
                        <?php
                        $query = "SELECT * FROM Tables";
                        $ret = mysqli_query($connection, $query);
                        $count = mysqli_num_rows($ret);
                        
                        if ($count == 0) {
                            echo '<div class="col-12 no-tables">No tables available at the moment.</div>';
                        } else {
                            for($a=0; $a <$count; $a+=4) {
                                $query1 = "SELECT * FROM Tables ORDER BY TableID LIMIT $a,4";
                                $ret1 = mysqli_query($connection,$query1);
                                $count2 = mysqli_num_rows($ret1);
                                
                                echo "<div class='row mb-4'>";
                                
                                for ($i=0; $i < $count2; $i++) {
                                    $data = mysqli_fetch_array($ret1);
                                    $Table_ID = $data['TableID'];
                                    $Table_Name = $data['TableName'];
                                    $Table_Capacity = $data['Capacity'];
                                    $Table_Description = $data['TableLocation'];
                        ?>
                        <div class="col-lg-3 col-md-6 menu-item mb-4">
                            <div class="menu-card shadow h-100">
                                <img src="img/table-1.png" class="img-fluid" alt="<?php echo $Table_Name; ?>">
                                <div class="table-number">Table <?php echo $Table_ID; ?></div>
                                <div class="menu-desc p-4">
                                    <h4><?php echo $Table_Name; ?></h4>
                                    <p class="price text-muted">
                                        <i class="fas fa-user-friends mr-2"></i>Seats: <?php echo $Table_Capacity; ?>
                                    </p>
                                    <p class="menu-description"><?php echo $Table_Description; ?></p>
                                    <a href="tabledetails.php?TableID=<?php echo $Table_ID; ?>" class="btn btn-primary btn-sm mt-auto">Book Table</a>
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
            </div>
        </section>
</div>
</div>
        <!-- Footer -->
        <?php include('footer.php'); ?>
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