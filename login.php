<?php
session_start();
include('dbconnect.php');

if(isset($_POST['btnlogin'])) {
    $email = $_POST['txtemail'];
    $password = $_POST['txtpassword'];
    
    
    $customer_query = "SELECT * FROM customer WHERE CustomerEmail='$email'";
    $customer_result = mysqli_query($connection, $customer_query);
    
    if(mysqli_num_rows($customer_result) == 1) {
        $customer = mysqli_fetch_assoc($customer_result);
        
        if(password_verify($password, $customer['CustomerPassword'])) {
            
            $_SESSION['cid'] = $customer['CustomerID'];
            
            if($customer['CustomerRole'] == 'user') {
               
                echo "<script>alert('Login Successful')</script>";
                echo "<script>window.location='menu2.php'</script>";
            } else {
               
                echo "<script>alert('Admin Login Successful')</script>";
                echo "<script>window.location='admincustomerregister.php'</script>";
            }
            exit();
        } else {
            handleFailedLogin();
        }
    } else {
     
        $staff_query = "SELECT * FROM staff WHERE StaffEmail='$email'";
        $staff_result = mysqli_query($connection, $staff_query);
        
        if(mysqli_num_rows($staff_result) == 1) {
            $staff = mysqli_fetch_assoc($staff_result);
            
            if(password_verify($password, $staff['StaffPassword'])) {
                
                echo "<script>alert('Staff Login Successful')</script>";
                echo "<script>window.location='admincustomerregister.php'</script>";
                exit();
            } else {
                handleFailedLogin();
            }
        } else {
       
            handleFailedLogin();
        }
    }
}

function handleFailedLogin() {
    if(isset($_SESSION['loginError'])) {
        $countError = $_SESSION['loginError'];
        if ($countError == 1) {
            $_SESSION['loginError'] = 2;
            echo "<script>window.alert('Login failed! Please try again! Error Attempt 2')</script>";
        }
        if ($countError == 2) {
            echo "<script>window.alert('Login failed! Error Attempt 3! Account is locked for 10mins! Please try again later.')</script>";
            echo "<script>window.location='LoginTimer.php'</script>";
        }
    } else {
        $_SESSION['loginError'] = 1;
        echo "<script>window.alert('Login failed! Please try again! Error Attempt 1')</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Portal</title>
    <link rel="icon" type="image/png" href="img/weblogo.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .text{
            width: 100%;
            justify-content: center;
            display: flex;
        }
        .text a{
            text-decoration: none;
            color: #F39494;
        }
         .text a:hover{
            text-decoration: underline;
            color: #F34949;

         }
        body {
            font-family: 'Open Sans', sans-serif;
            background-color: #F4EDE5;
            color: #333;
        }

        .login-form {
            background: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: 50px auto;
        }

        .login-form h2 {
            font-family: 'Josefin Sans', sans-serif;
            font-size: 2rem;
            color: #333;
            margin-bottom: 30px;
            text-align: center;
        }

        .login-form label {
            font-weight: 600;
            margin-bottom: 5px;
            display: block;
            color: #666;
        }

        .login-form .form-control {
            border-radius: 5px;
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 20px;
            font-size: 1rem;
        }

        .login-form .form-control:focus {
            border-color: #636363;
            box-shadow: none;
        }

        .login-form .btn-login {
            background-color: #ff6b6b;
            border: none;
            padding: 10px 20px;
            font-size: 1rem;
            border-radius: 5px;
            width: 100%;
            transition: background-color 0.3s ease;
            color: white;
            margin-bottom: 10px;
        }

        .login-form .btn-login:hover {
            background-color: #ff4c4c;
            color: white;
        }

        .login-form .btn-cancel {
            background-color: #6c757d;
            border: none;
            padding: 10px 20px;
            font-size: 1rem;
            border-radius: 5px;
            width: 100%;
            transition: background-color 0.3s ease;
            color: white;
        }

        .login-form .btn-cancel:hover {
            background-color: #5a6268;
            color: white;
        }

        .login-options {
            text-align: center;
            margin-top: 20px;
        }

        .login-options a {
            color: #ff6b6b;
            text-decoration: none;
            font-weight: 600;
            margin: 0 10px;
        }

        .login-options a:hover {
            text-decoration: underline;
        }

        @media (max-width: 576px) {
            .login-form {
                padding: 20px;
                margin: 20px;
            }

            .login-form h2 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <?php include('navigation.php'); ?>
    <div class="login-form">
        <h2>Customer Login</h2>
        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="txtemail">Email</label>
                <input type="email" class="form-control" id="txtemail" name="txtemail" placeholder="Enter your email" required>
            </div>

            <div class="form-group">
                <label for="txtpassword">Password</label>
                <input type="password" class="form-control" id="txtpassword" name="txtpassword" placeholder="Enter your password" required>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <button type="submit" name="btnlogin" class="btn-login">Login</button>
                </div>
                <div class="col-md-6">
                    <button type="reset" name="btncancel" class="btn-cancel">Cancel</button>
                </div>
            </div>

           <div class="text"><a href="forgotpassword.php">Forgot Password?</a></div>
        </form>
    </div>

    <?php include('footer.php'); ?>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>