<?php
session_start();
include('dbconnect.php');


if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: reservation2.php");
    exit();
}


$required_fields = ['TableID', 'BookingDate', 'BookingTime', 'CustomerName', 'CustomerPhone', 'NumberOfPeople'];
foreach ($required_fields as $field) {
    if (empty($_POST[$field])) {
        echo "<script>alert('Please fill in all required fields'); window.history.back();</script>";
        exit();
    }
}

// Sanitize and validate input
$table_id = mysqli_real_escape_string($connection, $_POST['TableID']);
$booking_date = mysqli_real_escape_string($connection, $_POST['BookingDate']);
$booking_time = mysqli_real_escape_string($connection, $_POST['BookingTime']);
$customer_name = mysqli_real_escape_string($connection, $_POST['CustomerName']);
$customer_phone = mysqli_real_escape_string($connection, $_POST['CustomerPhone']);
$number_of_people = intval($_POST['NumberOfPeople']);
$special_requests = isset($_POST['SpecialRequests']) ? mysqli_real_escape_string($connection, $_POST['SpecialRequests']) : '';
$customer_id_in = isset($_POST['CustomerID']) ? intval($_POST['CustomerID']) : 0;
if ($customer_id_in==0) {
    $customer_id = 'Cus-0000';
}
else{
    $customer_id = $customer_id_in;
}



$table_query = "SELECT * FROM Tables WHERE TableID = '$table_id'";
$table_result = mysqli_query($connection, $table_query);
$table = mysqli_fetch_assoc($table_result);

if (!$table) {
    echo "<script>alert('Table not found'); window.location.href='reservation2.php';</script>";
    exit();
}


if ($number_of_people > $table['Capacity']) {
    echo "<script>alert('Number of people exceeds table capacity'); window.history.back();</script>";
    exit();
}


$insert_query = "INSERT INTO Booking (TableID, CustomerID, BookingDate, BookingTime, BookingName, BookingPhone, NumberOfPeople, SpecialRequests, Status, CreatedAt)
                VALUES ($table_id, '$customer_id', '$booking_date', '$booking_time', '$customer_name', '$customer_phone', $number_of_people, '$special_requests', 'Confirmed', NOW())";

$insert_result = mysqli_query($connection, $insert_query);

if (!$insert_result) {
    echo "<script>alert('Error processing your booking. Please try again.'); window.history.back();</script>";
    exit();
}

$booking_id = mysqli_insert_id($connection);


$booking_query = "SELECT b.*, t.TableName, t.Capacity 
                 FROM Booking b
                 JOIN Tables t ON b.TableID = t.TableID
                 WHERE b.BookingID = '$booking_id'";
$booking_result = mysqli_query($connection, $booking_query);
$booking = mysqli_fetch_assoc($booking_result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Booking Confirmation - The Urban Brew</title>
    <meta name="description" content="Booking Confirmation">
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
        #color{
            color: grey;
        
        }
        .confirmation-section {
            padding: 80px 0;
        }
        .confirmation-card {
            background: white;
            border: 1.5px solid #e0e0e0;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            padding: 40px;
            max-width: 800px;
            margin: 0 auto;
            text-align: center;
        }
        .confirmation-title {
            font-size: 2rem;
            margin-bottom: 1.5rem;
            color: #333;
            font-weight: 600;
        }
        .confirmation-icon {
            color: #4CAF50;
            font-size: 4rem;
            margin-bottom: 1.5rem;
        }
        .confirmation-subtitle {
            font-size: 1.2rem;
            color: #d65106;
            margin-bottom: 2rem;
        }
        .booking-details {
            background: #f9f9f9;
            border-radius: 8px;
            padding: 30px;
            margin-bottom: 30px;
            text-align: left;
        }
        .detail-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }
        .detail-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        .detail-label {
            font-weight: 600;
            color: #555;
            flex: 1;
        }
        .detail-value {
            color: #333;
            flex: 1;
            text-align: right;
        }
        .btn{
            background-color: #F34949 !important;
            color: white !important;
        }
        .btn-back {
            
            border: none;
            padding: 12px 30px;
            border-radius: 4px;
            font-weight: 600;
            transition: all 0.3s;
            font-size: 1.1rem;
            margin-top: 1rem;
            text-decoration: none;
            display: inline-block;
        }
        .btn-back:hover {
            background: #b54505;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(214, 81, 6, 0.3);
            color: white;
        }
        .booking-id {
            font-size: 1.5rem;
            color: #d65106;
            margin-bottom: 20px;
            font-weight: 600;
        }
    </style>
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
        <!-- Confirmation Section -->
        <section class="confirmation-section">
            <div class="container">
                <div class="confirmation-card">
                    <div class="confirmation-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h1 class="confirmation-title">Booking Confirmed!</h1>
                    <h2 class="confirmation-subtitle">Thank you for your reservation</h2>
                    
                    <div class="booking-id">
                        Booking Reference: #<?php echo $booking_id; ?>
                    </div>
                    
                    <div class="booking-details">
                        <div class="detail-item">
                            <span class="detail-label">Customer Name:</span>
                            <span class="detail-value"><?php echo htmlspecialchars($booking['BookingName']); ?></span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Phone Number:</span>
                            <span class="detail-value"><?php echo htmlspecialchars($booking['BookingPhone']); ?></span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Booking Date:</span>
                            <span class="detail-value"><?php echo date('F j, Y', strtotime($booking['BookingDate'])); ?></span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Booking Time:</span>
                            <span class="detail-value"><?php echo date('g:i A', strtotime($booking['BookingTime'])); ?></span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Table:</span>
                            <span class="detail-value"><?php echo htmlspecialchars($booking['TableName']); ?> (Capacity: <?php echo $booking['Capacity']; ?>)</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Number of People:</span>
                            <span class="detail-value"><?php echo $booking['NumberOfPeople']; ?></span>
                        </div>
                        <?php if (!empty($booking['SpecialRequests'])): ?>
                        <div class="detail-item">
                            <span class="detail-label">Special Requests:</span>
                            <span class="detail-value"><?php echo htmlspecialchars($booking['SpecialRequests']); ?></span>
                        </div>
                        <?php endif; ?>
                        <div class="detail-item">
                            <span class="detail-label">Status:</span>
                            <span class="detail-value" style="color: #4CAF50; font-weight: 600;"><?php echo $booking['Status']; ?></span>
                        </div>
                    </div>
                    
                    <p id="color">We've sent a confirmation to your phone number</p> <p>Please arrive 10 minutes before your reservation time</p>
                    
                    <a href="reservation2.php" class="btn btn-back">Back to Tables</a>
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
</body>
</html>