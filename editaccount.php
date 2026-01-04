<!DOCTYPE html>
<?php 
session_start();  
include('connections.php'); 
include('dbconnect.php');


$currentUser = null;
if(isset($_SESSION['customer_id'])) {
    $customerId = $_SESSION['customer_id'];
    $query = "SELECT * FROM Customer WHERE CustomerID = '$customerId'";
    $result = mysqli_query($connection, $query);
    $currentUser = mysqli_fetch_assoc($result);
}


if (isset($_POST['save'])) {
    $CustomerID = $_POST['customer_id'];
    $firstName = $_POST['customer_firstname'];
    $lastName = $_POST['customer_surname'];
    $nationalID = $_POST['customer_national_id'];
    $phone = $_POST['customer_phone'];
    $address = $_POST['customer_address'];
    $email = $_POST['customer_email'];
    $password = $_POST['customer_password'];


    $updatePassword = !empty($password);
    $errors = [];
    
    if ($updatePassword) {
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
    }

    if (empty($errors)) {
        
        $updates = [];
        
        if ($firstName != $currentUser['CustomerFirstName']) {
            $updates[] = "CustomerFirstName = '$firstName'";
        }
        if ($lastName != $currentUser['CustomerLastName']) {
            $updates[] = "CustomerLastName = '$lastName'";
        }
        if ($nationalID != $currentUser['CustomerNationalID']) {
            $updates[] = "CustomerNationalID = '$nationalID'";
        }
        if ($phone != $currentUser['CustomerPhone']) {
            $updates[] = "CustomerPhone = '$phone'";
        }
        if ($address != $currentUser['CustomerAddress']) {
            $updates[] = "CustomerAddress = '$address'";
        }
        if ($email != $currentUser['CustomerEmail']) {
            $updates[] = "CustomerEmail = '$email'";
        }
        if ($updatePassword) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $updates[] = "CustomerPassword = '$hashedPassword'";
        }
        
        
        if (!empty($updates)) {
            $query = "UPDATE Customer SET " . implode(', ', $updates) . " WHERE CustomerID = '$CustomerID'";
            
            if (mysqli_query($connection, $query)) {
                echo "<script type='text/javascript'>
                        alert('Profile updated successfully');
                        window.location.href = 'editaccount.php';
                      </script>";
            } else {
                echo "<script type='text/javascript'>
                        alert('Error: " . mysqli_error($connection) . "');
                      </script>";
            }
        } else {
            echo "<script type='text/javascript'>
                    alert('No changes were made');
                  </script>";
        }
    } else {
        echo "<script type='text/javascript'>
                alert('" . implode("\\n", $errors) . "');
              </script>";
    }
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            background-color: #ffffff !important;
            color: #333;
        }

        .registration-form {
            background: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
            max-width: 600px;
            margin: 50px auto;
        }

        .registration-form h2 {
            font-family: 'Josefin Sans', sans-serif;
            font-size: 2rem;
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }

        .registration-form label {
            font-weight: 600;
            margin-bottom: 5px;
            display: block;
            color: #666;
        }

        .registration-form .form-control {
            border-radius: 5px;
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 20px;
            font-size: 1rem;
        }

        .registration-form .form-control::placeholder {
            color: #999;
            opacity: 1;
        }

        .registration-form .form-control:focus {
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

        .validation-message {
            font-size: 0.875rem;
            color: #666;
            margin-top: -10px;
            margin-bottom: 15px;
        }

        .validation-message ul {
            padding-left: 0;
        }

        .validation-message ul li {
            margin-bottom: 5px;
        }

        .validation-message ul li.valid {
            color: #28a745;
            font-weight: bold;
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
        
        .password-note {
            font-size: 0.9rem;
            color: #666;
            margin-top: -15px;
            margin-bottom: 15px;
            font-style: italic;
        }
    </style>
</head>
<body>
    <?php include('navigation.php'); ?>
    
    <?php if (isset($_SESSION['cid']) && $_SESSION['cid'] > 0): ?>
        <?php 
        $customer_ID = $_SESSION['cid'];
        $query = "SELECT * FROM Customer WHERE CustomerID='$customer_ID'";
        $ret = mysqli_query($connection, $query);
        $row = mysqli_fetch_array($ret);
        $fname = $row['CustomerFirstName'];
        $lname = $row['CustomerLastName'];
        $nationalid = $row['CustomerNationalID'];
        $cphone = $row['CustomerPhone'];
        $address = $row['CustomerAddress'];
        $cemail = $row['CustomerEmail'];
        ?>
        
        <div class="container">
            <div class="registration-form">
                <h2>Edit Profile</h2>
                <form action="editaccount.php" method="post" onsubmit="return validatePassword()">
                    <div class="form-group">
                        <label for="customer_id">Customer ID</label>
                        <input type="text" class="form-control" id="customer_id" name="customer_id" required 
                               value="<?php echo htmlspecialchars($customer_ID); ?>" readonly>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="customer_firstname">First Name</label>
                                <input type="text" class="form-control" id="customer_firstname" name="customer_firstname" 
                                       placeholder="Enter First Name" required 
                                       value="<?php echo htmlspecialchars($fname); ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="customer_surname">Surname</label>
                                <input type="text" class="form-control" id="customer_surname" name="customer_surname" 
                                       placeholder="Enter Surname" required 
                                       value="<?php echo htmlspecialchars($lname); ?>">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="customer_national_id">National ID</label>
                        <input type="text" class="form-control" id="customer_national_id" name="customer_national_id" 
                               placeholder="Enter National ID" required 
                               value="<?php echo htmlspecialchars($nationalid); ?>">
                    </div>

                    <div class="form-group">
                        <label for="customer_phone">Phone Number</label>
                        <input type="tel" class="form-control" id="customer_phone" name="customer_phone" 
                               placeholder="Enter Phone Number" required 
                               value="<?php echo htmlspecialchars($cphone); ?>">
                    </div>

                    <div class="form-group">
                        <label for="customer_address">Address</label>
                        <input type="text" class="form-control" id="customer_address" name="customer_address" 
                               placeholder="Enter Address" required 
                               value="<?php echo htmlspecialchars($address); ?>">
                    </div>

                    <div class="form-group">
                        <label for="customer_email">Email Address</label>
                        <input type="email" class="form-control" id="customer_email" name="customer_email" 
                               placeholder="Enter Email Address" required 
                               value="<?php echo htmlspecialchars($cemail); ?>">
                    </div>

                    <div class="form-group">
                        <label for="customer_password">New Password (leave blank to keep current password)</label>
                        <input type="password" class="form-control" id="customer_password" name="customer_password" 
                               placeholder="Enter new password" oninput="validatePasswordLive()">
                        <p class="password-note"><b>Only enter a password if you want to change it</b></p>
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

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary" name="save">Save</button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <a href="profile.php" class="btn btn-secondary">Cancel</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?>
    
    <?php include('footer.php'); ?>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        function validatePasswordLive() {
            const password = document.getElementById('customer_password').value;
            const length = document.getElementById('length');
            const uppercase = document.getElementById('uppercase');
            const lowercase = document.getElementById('lowercase');
            const number = document.getElementById('number');

            if (password.length > 0) {
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
            } else {
                length.classList.remove('valid');
                uppercase.classList.remove('valid');
                lowercase.classList.remove('valid');
                number.classList.remove('valid');
            }
        }

        function validatePassword() {
            const password = document.getElementById('customer_password').value;
            const errors = [];

            if (password.length > 0) {
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