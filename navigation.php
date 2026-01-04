<?php include ('connections.php'); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
   
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <nav id="navbar-header" class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand navbar-brand-center d-flex align-items-center p-0 only-mobile" href="/">
           <img src="img/logo.png" alt="The Urban Brew Logo" class="hidelogo">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="lnr lnr-menu"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-between" id="navbarSupportedContent">
            <ul class="navbar-nav d-flex justify-content-between">
                <li class="nav-item only-desktop">
                    <a class="nav-link" id="side-nav-open" href="#">
                        <span class="lnr lnr-menu"></span>
                    </a>
                </li>
                <div class="d-flex flex-lg-row flex-column">
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php">Home<span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="menu2.php">Menu</a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Account
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                           <?php if (isset($_SESSION['cid']) && $_SESSION['cid'] > 0): ?>
                                <a class="dropdown-item" href="logout.php">Logout</a>
                                <a class="dropdown-item" href="editaccount.php">Edit Account</a>
                            <?php else: ?>
                                <a class="dropdown-item" href="login.php">Login</a>
                            <?php endif; ?>
                          <a class="dropdown-item" href="userregister.php">Register</a>
                        </div>
                    </li>
                </div>
            </ul>
            
            <a class="navbar-brand navbar-brand-center d-flex align-items-center only-desktop" href="index.php">
                <img src="img/logo.png" alt="The Urban Brew Logo" >
            </a>
            <ul class="navbar-nav d-flex justify-content-between">
                <div class="d-flex flex-lg-row flex-column">
                    <li class="nav-item active">
                        <a class="nav-link" href="about.php">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Shopping_Cart.php">Cart</a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link" href="reservation2.php">Reservation</a>
                    </li>

                    <li class="nav-item dropdown">
                    <?php if (isset($_SESSION['cid']) && $_SESSION['cid'] > 0):
                         $customer_ID=$_SESSION['cid'];
                            $query="SELECT * From Customer WHERE CustomerID='$customer_ID'";
                            $ret=mysqli_query($connection,$query);
                            $row=mysqli_fetch_array($ret);
                            $username = $row['CustomerFirstName'];
                     ?>
       <b class="nav-link border"> Welcome, <?php echo htmlspecialchars($username); ?></b>
    <?php endif; ?>
</li>

                </div>
               
            </ul>
        </div>
    </div>
</nav>  
<hr>
<style type="text/css">
    @media (min-width: 1200px) {
 .hidelogo{
    display: none;
 }
}
    nav{
        box-shadow: 2px 2px 5px #dbdbdb;
    }
    .border{
        background-color: #F34949 !important;
        color: #f5f5f5;
        border-radius: 10px;
    }
    b:hover{
        color: #f5f5f5 !important;
    }
</style>
</body>
</html>