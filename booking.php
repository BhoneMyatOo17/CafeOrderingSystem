<?php
session_start();
include('dbconnect.php');


if(!isset($_POST['TableID']) || !isset($_POST['BookingDate'])) {
    echo "<script>alert('Invalid booking request'); window.location.href='tables.php';</script>"; 
    exit();
}


$Table_ID = $_POST['TableID'];
$Booking_Date = $_POST['BookingDate'];
$query = "SELECT * FROM Tables WHERE TableID = '$Table_ID'";
$result = mysqli_query($connection, $query);
$row = mysqli_fetch_array($result);

if(!$row) {
    echo "<script>alert('Table Not Found'); window.location.href='tables.php';</script>"; 
    exit();
}

$Table_Name = $row['TableName'];
$Table_Capacity = $row['Capacity'];
$Customer_ID = $_SESSION['CustomerID'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Book <?php echo $Table_Name; ?> - The Urban Brew</title>
    <meta name="description" content="Book Your Table">
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
        .btn{
            background-color: #F34949 !important;
            color: white !important;
        }
        .booking-section {
            padding: 80px 0;
        }
        .booking-card {
            background: white;
            border: 1.5px solid #e0e0e0;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            padding: 40px;
            max-width: 800px;
            margin: 0 auto;
        }
        .booking-title {
            font-size: 2rem;
            margin-bottom: 1.5rem;
            color: #333;
            font-weight: 600;
            text-align: center;
        }
        .booking-subtitle {
            font-size: 1.2rem;
            color: #d65106;
            margin-bottom: 2rem;
            text-align: center;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-label {
            font-weight: 600;
            color: #555;
            display: block;
            margin-bottom: 8px;
        }
        .form-control {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
        }
        .form-control:focus {
            border-color: #d65106;
            box-shadow: 0 0 0 0.2rem rgba(214, 81, 6, 0.25);
        }
        .btn-submit-booking {
            background: #d65106;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 4px;
            font-weight: 600;
            transition: all 0.3s;
            width: 100%;
            font-size: 1.1rem;
            margin-top: 1rem;
        }
        .btn-submit-booking:hover {
            background: #b54505;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(214, 81, 6, 0.3);
        }
        .booking-summary {
            background: #f9f9f9;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 30px;
        }
        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        .summary-label {
            font-weight: 600;
            color: #555;
        }
        .summary-value {
            color: #333;
        }
        .time-slots {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }
        .time-slot {
            padding: 8px 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.2s;
        }
        .time-slot:hover {
            background: #f0f0f0;
        }
        .time-slot.selected {
            background: #d65106;
            color: white;
            border-color: #d65106;
        }
        textarea {
            min-height: 100px;
            resize: vertical;
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
        <!-- Booking Section -->
        <section class="booking-section">
            <div class="container">
                <div class="booking-card">
                    <h1 class="booking-title">Book Your Table</h1>
                    <h2 class="booking-subtitle"><?php echo $Table_Name; ?> (Capacity: <?php echo $Table_Capacity; ?>)</h2>
                    
                    <div class="booking-summary">
                        <div class="summary-item">
                            <span class="summary-label">Booking Date:</span>
                            <span class="summary-value"><?php echo date('F j, Y', strtotime($Booking_Date)); ?></span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">Table:</span>
                            <span class="summary-value"><?php echo $Table_Name; ?></span>
                        </div>
                    </div>
                    
                    <form action="bookingdetails.php" method="POST" id="bookingForm">
                        <input type="hidden" name="TableID" value="<?php echo $Table_ID; ?>">
                        <input type="hidden" name="BookingDate" value="<?php echo $Booking_Date; ?>">
                        <input type="hidden" name="CustomerID" value="<?php echo $Customer_ID; ?>">
                        
                        <div class="form-group">
                            <label for="CustomerName" class="form-label">Full Name *</label>
                            <input type="text" class="form-control" id="CustomerName" name="CustomerName" required 
                                   value="<?php echo $_SESSION['CustomerName'] ?? ''; ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="CustomerPhone" class="form-label">Phone Number *</label>
                            <input type="tel" class="form-control" id="CustomerPhone" name="CustomerPhone" required
                                   value="<?php echo $_SESSION['CustomerPhone'] ?? ''; ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="BookingTime" class="form-label">Booking Time *</label>
                            <select class="form-control" id="BookingTime" name="BookingTime" required>
                                <option value="">Select a time</option>
                                <option value="09:00:00">9:00 AM</option>
                                <option value="10:00:00">10:00 AM</option>
                                <option value="11:00:00">11:00 AM</option>
                                <option value="12:00:00">12:00 PM</option>
                                <option value="13:00:00">1:00 PM</option>
                                <option value="14:00:00">2:00 PM</option>
                                <option value="15:00:00">3:00 PM</option>
                                <option value="16:00:00">4:00 PM</option>
                                <option value="17:00:00">5:00 PM</option>
                                <option value="18:00:00">6:00 PM</option>
                                <option value="19:00:00">7:00 PM</option>
                                <option value="20:00:00">8:00 PM</option>
                                <option value="21:00:00">9:00 PM</option>
                                <option value="22:00:00">10:00 PM</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="NumberOfPeople" class="form-label">Number of People *</label>
                            <input type="number" class="form-control" id="NumberOfPeople" name="NumberOfPeople" 
                                   min="1" max="<?php echo $Table_Capacity; ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="SpecialRequests" class="form-label">Special Requests</label>
                            <textarea class="form-control" id="SpecialRequests" name="SpecialRequests" 
                                      placeholder="Any special requirements or notes for your booking..."></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-submit-booking">Confirm Booking</button>
                    </form>
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
        
        $(document).ready(function() {
            $('.time-slot').click(function() {
                $('.time-slot').removeClass('selected');
                $(this).addClass('selected');
                $('#BookingTime').val($(this).data('time'));
            });
            
          
            $('#bookingForm').submit(function(e) {
                const numPeople = parseInt($('#NumberOfPeople').val());
                const capacity = parseInt(<?php echo $Table_Capacity; ?>);
                
                if (numPeople > capacity) {
                    alert('Number of people cannot exceed table capacity of ' + capacity);
                    e.preventDefault();
                    return false;
                }
                
                return true;
            });
        });
    </script>
</body>
</html>