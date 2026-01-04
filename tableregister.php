<!DOCTYPE html>
<?php session_start();  
include('connections.php'); 

include('dbconnect.php');
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Table Management</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            background-color: #F4EDE5 !important;
            color: #333;
        }

        .registration-form {
            background: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: 50px auto;
        }

        .registration-form h2 {
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

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            font-weight: 600;
            margin-bottom: 5px;
            display: block;
            color: #666;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 1rem;
        }

        .form-group input:focus,
        .form-group select:focus {
            border-color: #636363;
            box-shadow: none;
        }
        .registration-form .btn-primary {
            background-color: #ff6b6b;
            border: none;
            padding: 10px 20px;
            font-size: 1rem;
            border-radius: 5px;
            width: 100%;
            transition: background-color 0.3s ease;
        }

        .registration-form .btn-primary:hover {
            background-color: #ff4c4c;
        }

        .registration-form .btn-secondary {
            background-color: #6c757d;
            border: none;
            padding: 10px 20px;
            font-size: 1rem;
            border-radius: 5px;
            width: 100%;
            transition: background-color 0.3s ease;
        }

        .registration-form .btn-secondary:hover {
            background-color: #5a6268;
            color: white;
        }

        @media (max-width: 576px) {
            .registration-form {
                padding: 20px;
                margin-top: 86px;
            }

            .registration-form h2 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <?php
   
    if (isset($_POST['submit'])) {
        $name = $_POST['tablename'];
        $cap = $_POST['tbcapacity'];
        $location = $_POST['tblocation'];

        
        $query = "INSERT INTO `Tables` (TableName, Capacity, TableLocation)
                  VALUES ('$name', $cap, '$location')";

        if (mysqli_query($connection, $query)) {
            echo "<script type='text/javascript'>
                    alert('Table Registered Successfully');
                    window.location.href = 'tableregister.php';
                  </script>";
        } else {
            echo "<script type='text/javascript'>
                    alert('Error: " . mysqli_error($connection) . "');
                  </script>";
        }
    }
    ?>

    <?php include('adminnavigation.php'); ?>
    <div class="registration-form">
        <h2>Table Registration</h2>
        <form action="tableregister.php" method="post">
            <!-- Table Name -->
            <div class="form-group">
                <label for="tablename">Table Name</label>
                <input type="text" class="form-control" id="tablename" name="tablename" placeholder="Enter Table Name" required>
            </div>

            <!-- Capacity -->
            <div class="form-group">
                <label for="tbcapacity">Capacity</label>
                <input type="number" class="form-control" id="tbcapacity" name="tbcapacity" placeholder="Enter Table Capacity" required>
            </div>

            <!-- Location -->
            <div class="form-group">
                <label for="tblocation">Table Location</label>
                <input type="text" class="form-control" id="tblocation" name="tblocation" placeholder="Enter Table Location" required>
            </div>

            <!-- Buttons Side by Side -->
             <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" name="submit">Register</button>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <button type="reset" class="btn btn-secondary">Cancel</button>
                    </div>
                </div>
            </div>
        </form>

        <!-- List of Registered Tables -->
        <h2>Registered Tables</h2>
        <div class="table-list">
             <?php
    if (isset($_GET['delete_id'])) {
        $delete_id = $_GET['delete_id'];
        $delete_query = "DELETE FROM Tables WHERE TableID = '$delete_id'";
        mysqli_query($connection, $delete_query);
    }

    $query = "SELECT * FROM Tables";
            $result = mysqli_query($connection, $query);


    if ($result && mysqli_num_rows($result) > 0) {
        echo "<table>
                <thead>
                    <tr>
                        <th>Table Name</th>
                        <th>Capacity</th>
                        <th>Loaction</th>
                        <th>Deletion</th>
                    </tr>
                </thead>
                <tbody>";

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$row['TableName']}</td>
                    <td>{$row['Capacity']}</td>
                    <td>{$row['TableLocation']}</td>
                    <td>
                        <a href='?delete_id={$row['TableID']}' onclick=\"return confirm('Are you sure you want to remove this Table?');\">Remove</a>
                    </td>
                  </tr>";
        }

        echo "</tbody></table>";
    } else {
        echo "<p>No Table found in the database.</p>";
    }
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