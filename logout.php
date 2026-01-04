<?php 
session_start();
include('dbconnect.php');
include('connections.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Logged Out - The Urban Brew</title>
    <meta name="description" content="You have been logged out">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" href="image/weblogo.png">
    <!-- External CSS -->
    <link rel="stylesheet" href="vendor/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.1/css/brands.css">
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700|Josefin+Sans:300,400,700">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
    <style>
        body {
            background-color: #fafafa;
            font-family: 'Open Sans', sans-serif;
        }
        .logout-section {
            padding: 20px 0;
            min-height: 60vh;
            display: flex;
            align-items: center;
        }
        .logout-container {
            max-width: 600px;
            margin: 0 auto;
            text-align: center;
        }
        .logout-card {
            background: white;
            border-radius: 12px;
            padding: 50px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            border-top: 5px solid #F34949;
        }
        .logout-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.12);
        }
        .logout-icon {
            font-size: 60px;
            color: #F34949;
            margin-bottom: 20px;
        }
        .logout-title {
            font-size: 2rem;
            color: #333;
            margin-bottom: 20px;
            font-weight: 600;
        }
        .logout-message {
            font-size: 1.1rem;
            color: #666;
            margin-bottom: 30px;
            line-height: 1.6;
        }
        .btn-home {
            background: #F34949;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 4px;
            font-weight: 600;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }
        .btn-home:hover {
            background: #F34949;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(214, 81, 6, 0.3);
        }
        @media (max-width: 768px) {
            .logout-section {
                padding: 60px 0;
            }
            .logout-card {
                padding: 30px;
            }
            .logout-title {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <?php 
    include('navigation.php');
    session_destroy();
    unset($_SESSION['role']);
    ?>
    
    <section class="logout-section">
        <div class="container">
            <div class="logout-container">
                <div class="logout-card">
                    <div class="logout-icon">
                        <i class="fas fa-sign-out-alt"></i>
                    </div>
                    <h2 class="logout-title">You've Been Logged Out</h2>
                    <p class="logout-message">
                        You have successfully logged out of your account.<br>
                        Thank you for visiting The Urban Brew.
                    </p>
                    <a href="index.php" class="btn-home">
                        <i class="fas fa-home"></i> Return to Home Page
                    </a>
                </div>
            </div>
        </div>
    </section>
    <hr>
    <?php include('footer.php'); ?>
    
    <!-- JavaScript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="vendor/bootstrap/bootstrap.min.js"></script>
</body>
</html>