<!DOCTYPE html>
<?php session_start(); include('connections.php'); 
include('dbconnect.php');
include('autoid.php'); 
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Staff Registration Form</title>
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
        $staffID = $_POST['staff_id'];
        $firstName = $_POST['staff_firstname'];
        $lastName = $_POST['staff_surname'];
        $nationalID = $_POST['staff_national_id'];
        $phone = $_POST['staff_phone'];
        $address = $_POST['staff_address'];
        $email = $_POST['staff_email'];
        $password = $_POST['staff_password'];

      
        $errors = [];
        if (strlen($password) < 8) {
            $errors[] = "Password must be at least 8 characters long.";
        }
        if (!preg_match("/[A-Z]/", $password)) {
            $errors[] = "Password must include at least one uppercase letter.";
        }
        if (!preg_match("/[a-z]/", $password)) {
            $errors[] = "Password must include at least one lowercase letter.";
        }
        if (!preg_match("/[0-9]/", $password)) {
            $errors[] = "Password must include at least one number.";
        }

      
        if (empty($errors)) {
           
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            
            $query = "INSERT INTO Staff (StaffID, StaffFirstName, StaffLastName, StaffNationalID, StaffPhone, StaffAddress, StaffEmail, StaffPassword)
                      VALUES ('$staffID', '$firstName', '$lastName', '$nationalID', '$phone', '$address', '$email', '$hashedPassword')";

            if (mysqli_query($connection, $query)) {
                echo "<script type='text/javascript'>
                        alert('Staff Registered Successfully');
                        window.location.href = 'staffregister.php';
                      </script>";
            } else {
                echo "<script type='text/javascript'>
                        alert('Error: " . mysqli_error($connection) . "');
                      </script>";
            }
        }
    }
    ?>

    <?php include('adminnavigation.php'); ?>
    <div class="registration-form">
        <h2>Staff Registration</h2>
        <form action="staffregister.php" method="post" onsubmit="return validatePassword()">
            <!-- Staff ID -->
            <div class="form-group">
                <label for="staff_id">Staff ID</label>
                <input type="text" class="form-control" id="staff_id" name="staff_id" required value="<?php echo AutoID("Staff", "StaffID", "S-", 4); ?>" readonly>
            </div>

            <!-- First Name and Surname -->
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="staff_firstname">First Name</label>
                        <input type="text" class="form-control" id="staff_firstname" name="staff_firstname" placeholder="Enter First Name" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="staff_surname">Surname</label>
                        <input type="text" class="form-control" id="staff_surname" name="staff_surname" placeholder="Enter Surname" required>
                    </div>
                </div>
            </div>

            <!-- National ID -->
            <div class="form-group">
                <label for="staff_national_id">National ID</label>
                <input type="text" class="form-control" id="staff_national_id" name="staff_national_id" placeholder="Enter National ID" required>
            </div>

            <!-- Phone Number -->
            <div class="form-group">
                <label for="staff_phone">Phone Number</label>
                <input type="tel" class="form-control" id="staff_phone" name="staff_phone" placeholder="Enter Phone Number" required>
            </div>

            <!-- Address -->
            <div class="form-group">
                <label for="staff_address">Address</label>
                <input type="text" class="form-control" id="staff_address" name="staff_address" placeholder="Enter Address" required>
            </div>

            <!-- Email Address -->
            <div class="form-group">
                <label for="staff_email">Email Address</label>
                <input type="email" class="form-control" id="staff_email" name="staff_email" placeholder="Enter Email Address" required>
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="staff_password">Password</label>
                <input type="password" class="form-control" id="staff_password" name="staff_password" placeholder="Create a Password" required oninput="validatePasswordLive()">
                <div class="validation-message" id="password-validation">
                    Password must:
                    <ul>
                        <li id="length">Be at least 8 characters long</li>
                        <li id="uppercase">Include at least one uppercase letter</li>
                        <li id="lowercase">Include at least one lowercase letter</li>
                        <li id="number">Include at least one number</li>
                    </ul>
                </div>
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
        <h2>Registered Staff</h2>
<div class="table-list">
    <?php
    if (isset($_GET['delete_id'])) {
        $delete_id = $_GET['delete_id'];
        $delete_query = "DELETE FROM Staff WHERE StaffID = '$delete_id'";
        mysqli_query($connection, $delete_query);
    }

    $query = "SELECT * FROM Staff";
    $result = mysqli_query($connection, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        echo "<table>
                <thead>
                    <tr>
                        <th>Staff Name</th>
                        <th>Staff Phone</th>
                        <th>Email Address</th>
                        <th>Deletion</th>
                    </tr>
                </thead>
                <tbody>";

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$row['StaffFirstName']} {$row['StaffLastName']}</td>
                    <td>{$row['StaffPhone']}</td>
                    <td>{$row['StaffEmail']}</td>
                    <td>
                        <a href='?delete_id={$row['StaffID']}' onclick=\"return confirm('Are you sure you want to remove this staff member?');\">Remove</a>
                    </td>
                  </tr>";
        }

        echo "</tbody></table>";
    } else {
        echo "<p>No staff found in the database.</p>";
    }
    ?>
</div>

    </div>
 <?php include('footer.php'); ?>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- JavaScript for Live Password Validation -->
    <script>
        function validatePasswordLive() {
            const password = document.getElementById('staff_password').value;
            const length = document.getElementById('length');
            const uppercase = document.getElementById('uppercase');
            const lowercase = document.getElementById('lowercase');
            const number = document.getElementById('number');

           
            if (password.length >= 8) {
                length.classList.add('valid');
            } else {
                length.classList.remove('valid');
            }

            
            if (/[A-Z]/.test(password)) {
                uppercase.classList.add('valid');
            } else {
                uppercase.classList.remove('valid');
            }

           
            if (/[a-z]/.test(password)) {
                lowercase.classList.add('valid');
            } else {
                lowercase.classList.remove('valid');
            }

          
            if (/[0-9]/.test(password)) {
                number.classList.add('valid');
            } else {
                number.classList.remove('valid');
            }
        }

        function validatePassword() {
            const password = document.getElementById('staff_password').value;
            const errors = [];

            if (password.length < 8) {
                errors.push("Password must be at least 8 characters long.");
            }
            if (!/[A-Z]/.test(password)) {
                errors.push("Password must include at least one uppercase letter.");
            }
            if (!/[a-z]/.test(password)) {
                errors.push("Password must include at least one lowercase letter.");
            }
            if (!/[0-9]/.test(password)) {
                errors.push("Password must include at least one number.");
            }

            if (errors.length > 0) {
                alert(errors.join("\n"));
                return false;
            }
            return true;
        }
    </script>
</body>
</html>