<!DOCTYPE html>
<?php session_start(); 
include('connections.php'); 
include('dbconnect.php');
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Booking Records</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            background-color: #F4EDE5 !important;
            color: #333;
        }

        .booking-container {
            background: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            max-width: 1200px;
            margin: 50px auto;
        }

        .booking-container h2 {
            font-family: 'Josefin Sans', sans-serif;
            font-size: 2rem;
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }

        .table-list {
            margin-top: 20px;
        }

        .table-list table {
            width: 100%;
            border-collapse: collapse;
        }

        .table-list th,
        .table-list td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .table-list th {
            background-color: #ff6b6b;
            color: #fff;
        }

        .table-list tr:hover {
            background-color: #f5f5f5;
        }

        .search-box {
            margin-bottom: 20px;
        }

        .search-box .input-group {
            width: 100%;
        }

        .search-box input {
            padding: 10px;
            border: 1px solid #ddd;
            font-size: 1rem;
            border-radius: 5px 0 0 5px;
        }

        .search-box button {
            background-color: #ff6b6b;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 0 5px 5px 0;
            transition: background-color 0.3s ease;
        }

        .search-box button:hover {
            background-color: #ff4c4c;
        }
        .btn-search{
            height: 39px;
        }
        .status-pending { color: #FFA500; font-weight: bold; }
        .status-confirmed { color: #228B22; font-weight: bold; }
        .status-cancelled { color: #DC143C; font-weight: bold; }
        .status-completed { color: #4169E1; font-weight: bold; }

        .action-links a {
            color: #ff6b6b;
            margin-right: 10px;
        }

        .action-links a:hover {
            text-decoration: underline;
        }

        @media (max-width: 576px) {
            .booking-container {
                padding: 20px;
                margin-top: 86px;
            }

            .booking-container h2 {
                font-size: 1.5rem;
            }
            
            .table-list th, 
            .table-list td {
                padding: 8px;
                font-size: 0.9rem;
            }
        }

    </style>
</head>
<body>
    <?php include('adminnavigation.php'); ?>
    
    <div class="booking-container">
        <h2>Booking Records</h2>
        
        <!-- Search Box with Button -->
        <div class="search-box">
            <form method="GET" action="" class="input-group">
                <input type="text" name="search" placeholder="Search bookings by name, phone, or ID..." 
                       value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>" class="form-control">
                <button type="submit" class="btn btn-search">
                    <i class="fas fa-search"></i> Search
                </button>
            </form>
        </div>
        
        <div class="table-list">
            <?php
            // Handle booking deletion
            if (isset($_GET['delete_id'])) {
                $delete_id = $_GET['delete_id'];
                $delete_query = "DELETE FROM Booking WHERE BookingID = '$delete_id'";
                mysqli_query($connection, $delete_query);
                            }

            // Build the search query
            $search = isset($_GET['search']) ? $_GET['search'] : '';
            $query = "SELECT * FROM Booking";
            
            if (!empty($search)) {
                $query .= " WHERE 
                    BookingID LIKE '%$search%' OR 
                    BookingName LIKE '%$search%' OR 
                    BookingPhone LIKE '%$search%'";
            }
            
            $query .= " ORDER BY BookingDate DESC, BookingTime DESC";
            $result = mysqli_query($connection, $query);

            if ($result && mysqli_num_rows($result) > 0) {
                echo "<table>
                        <thead>
                            <tr>
                                <th>Booking ID</th>
                                <th>Customer Name</th>
                                <th>Table Name</th>
                                <th>Phone</th>
                                <th>Date & Time</th>
                                <th>People</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>";

                while ($row = mysqli_fetch_assoc($result)) {
                    // Format the date and time
                    $bookingDate = date('M j, Y', strtotime($row['BookingDate']));
                    $bookingTime = date('g:i A', strtotime($row['BookingTime']));
                    
                    // Status with color coding
                    $statusClass = strtolower($row['Status']);
                    $statusDisplay = "<span class='status-$statusClass'>{$row['Status']}</span>";
                    $Table_ID = $row['TableID'];
                    $query = "SELECT * FROM Tables WHERE TableID = '$Table_ID'";
                    $result2 = mysqli_query($connection, $query);
                    $row2 = mysqli_fetch_array($result2);
                    $tableName = $row2['TableName'];
                    echo "<tr>
                            <td>{$row['BookingID']}</td>
                            <td>{$row['BookingName']}</td>
                            <td>{$tableName}</td>
                            <td>{$row['BookingPhone']}</td>
                            <td>$bookingDate<br><small>$bookingTime</small></td>
                            <td>{$row['NumberOfPeople']}</td>
                            <td>$statusDisplay</td>
                            <td class='action-links'>
                                
                                <a href='?delete_id={$row['BookingID']}' onclick=\"return confirm('Are you sure you want to delete this booking?');\">Delete</a>
                            </td>
                          </tr>";
                }

                echo "</tbody></table>";
            } else {
                echo "<p>No bookings found.</p>";
            }
            
            mysqli_close($connection);
            ?>
        </div>
    </div>
    
    <?php include('footer.php'); ?>
    
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>