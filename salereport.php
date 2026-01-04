<!DOCTYPE html>
<?php 
session_start(); 
include('dbconnect.php');
include('connections.php');
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Sales Report</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .btn-search{
            height: 38px;
            font-size: 15px;
        }
        body {
            font-family: 'Open Sans', sans-serif;
            background-color: #F4EDE5 !important;
            color: #333;
        }

        .sales-container {
            background: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            max-width: 1400px;
            margin: 50px auto;
        }

        .sales-container h2 {
            font-family: 'Josefin Sans', sans-serif;
            font-size: 2rem;
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }

        .search-box {
            margin-bottom: 25px;
        }

        .search-box .input-group {
            width: 100%;
            max-width: 500px;
            margin: 0 auto;
        }

        .search-box input {
            padding: 12px 15px;
            border: 1px solid #ddd;
            font-size: 1rem;
            border-radius: 5px 0 0 5px;
        }

        .search-box button {
            background-color: #ff6b6b;
            color: white;
            border: none;
            padding: 12px 20px;
            cursor: pointer;
            border-radius: 0 5px 5px 0;
            transition: background-color 0.3s ease;
        }

        .search-box button:hover {
            background-color: #ff4c4c;
        }

        .order-list {
            margin-top: 20px;
            overflow-x: auto;
        }

        .order-list table {
            width: 100%;
            border-collapse: collapse;
            min-width: 1000px;
        }

        .order-list th,
        .order-list td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }

        .order-list th {
            background-color: #ff6b6b;
            color: #fff;
            position: sticky;
            top: 0;
            font-weight: 600;
        }

        .order-list tr:nth-child(even) {
            background-color: #fafafa;
        }

        .order-list tr:hover {
            background-color: #f5f5f5;
        }

        /* Status colors */
        .status-pending { color: #FFA500; font-weight: bold; }
        .status-processing { color: #4169E1; font-weight: bold; }
        .status-completed { color: #228B22; font-weight: bold; }
        .status-cancelled { color: #DC143C; font-weight: bold; }
        .status-delivered { color: #008000; font-weight: bold; }
        .status-refunded { color: #6A5ACD; font-weight: bold; }

        .action-links a {
            color: #ff6b6b;
            margin-right: 10px;
            transition: color 0.3s ease;
        }

        .action-links a:hover {
            color: #ff4c4c;
            text-decoration: none;
        }

        .total-amount {
            font-weight: bold;
            color: #333;
        }

        .tax-amount {
            color: #666;
            font-size: 0.85em;
        }

        @media (max-width: 768px) {
            .sales-container {
                padding: 25px;
                margin-top: 86px;
            }

            .sales-container h2 {
                font-size: 1.7rem;
            }

            .search-box .input-group {
                max-width: 100%;
            }
        }

        @media (max-width: 576px) {
            .sales-container {
                padding: 20px;
            }

            .sales-container h2 {
                font-size: 1.5rem;
            }

            .search-box input,
            .search-box button {
                padding: 10px 12px;
            }
        }
    </style>
</head>
<body>
    <?php include('adminnavigation.php'); ?>
    
    <div class="sales-container">
        <h2>Sales Report</h2>
        
        <!-- Search Box -->
        <div class="search-box">
            <form method="GET" action="" class="input-group">
                <input type="text" name="search" placeholder="Search orders" 
                       value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>" class="form-control">
                <button type="submit" class="btn btn-search">
                    <i class="fas fa-search"></i> Search
                </button>
            </form>
        </div>
        
        <div class="order-list">
            <?php
           
            if (isset($_GET['delete_id'])) {
                $delete_id = $_GET['delete_id'];
                $delete_query = "DELETE FROM Orders WHERE Order_ID = '$delete_id'";
                mysqli_query($connection, $delete_query);
                
            }

           
            $search = isset($_GET['search']) ? $_GET['search'] : '';
            $query = "SELECT * FROM Orders";
            
            if (!empty($search)) {
                $query .= " WHERE 
                    Order_ID LIKE '%$search%' OR 
                    CustomerID LIKE '%$search%' OR 
                    Order_Phone LIKE '%$search%' OR 
                    Payment_Type LIKE '%$search%' OR 
                    Order_Date LIKE '%$search%' OR 
                    Order_Status LIKE '%$search%'";
            }
            
            $query .= " ORDER BY Order_Date DESC";
            $result = mysqli_query($connection, $query);

            if ($result && mysqli_num_rows($result) > 0) {
                echo "<table>
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Date</th>
                                <th>Customer</th>
                                <th>Phone</th>
                                <th>Items</th>
                                <th>Total Amount</th>
                                <th>Payment</th>
                                <th>Location</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>";

                while ($row = mysqli_fetch_assoc($result)) {
                   
                    $orderDate = date('M j, Y', strtotime($row['Order_Date']));
                    
               
                    $orderTotal = number_format($row['Order_Total_Amount'], 2);
                    $allTotal = number_format($row['All_Total'], 2);
                    $taxAmount = number_format($row['Tax'], 2);
                    
               
                    $statusClass = strtolower(str_replace(' ', '-', $row['Order_Status']));
                    $statusDisplay = "<span class='status-$statusClass'>{$row['Order_Status']}</span>";
                    
                    echo "<tr>
                            <td>{$row['Order_ID']}</td>
                            <td>$orderDate</td>
                            <td>{$row['CustomerID']}</td>
                            <td>{$row['Order_Phone']}</td>
                            <td>{$row['Order_quantity']}</td>
                            <td>
                                <span class='total-amount'>$$allTotal</span><br>
                                <span class='tax-amount'>($$orderTotal + $$taxAmount tax)</span>
                            </td>
                            <td>{$row['Payment_Type']}</td>
                            <td>{$row['Order_Location']}</td>
                            <td>$statusDisplay</td>
                            <td class='action-links'>
                                
                                <a href='?delete_id={$row['Order_ID']}' onclick=\"return confirm('Are you sure you want to delete this order?');\" title='Delete'><i class='fas fa-trash-alt'></i></a>
                            </td>
                          </tr>";
                }

                echo "</tbody></table>";
            } else {
                echo "<div class='alert alert-info text-center'>No orders found.</div>";
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
</body>
</html>