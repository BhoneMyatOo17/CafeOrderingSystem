<?php 
session_start();
include('dbconnect.php');
include('Shopping_Cart_Functions.php');

if(isset($_REQUEST['Action'])) 
{
    $Action=$_REQUEST['Action'];
    if($Action === "Remove")
    {
        $Product_ID=$_REQUEST['ProductID'];
        RemoveShoppingCart($Product_ID);
    }
    elseif ($Action === "Buy")
    {
        $txtProductID=$_REQUEST['txtProductID'];
        $txtBuyQty=$_REQUEST['txtBuyQty'];
        AddShoppingCart($txtProductID,$txtBuyQty);
    }
    else
    {
        ClearShoppingCart();
    }
}
else
{
    $Action="";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Shopping Cart - The Urban Brew</title>
    <meta name="description" content="Your Shopping Cart">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" href="img/weblogo.png">
    <!-- External CSS -->
    <link rel="stylesheet" href="vendor/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="vendor/select2/select2.min.css">
    <link rel="stylesheet" href="https://cdn.rawgit.com/noelboss/featherlight/1.7.13/release/featherlight.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.1/css/brands.css">

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700|Josefin+Sans:300,400,700">
    <link rel="stylesheet" href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">

    <!-- CSS -->
    <link rel="stylesheet" href="css/style.min.css">
    <style>
        .shopping-cart-section {
            padding: 80px 0;
        }
        .shopping-cart-container {
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            padding: 30px;
            margin-bottom: 30px;
        }
        .cart-title {
            font-size: 2rem;
            margin-bottom: 30px;
            color: #333;
            text-align: center;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }
        .empty-cart {
            text-align: center;
            padding: 40px 0;
        }
        .empty-cart-message {
            font-size: 1.2rem;
            margin-bottom: 20px;
            color: #666;
        }
        .continue-shopping-btn {
            background: #F34949;
            color: white;
            padding: 10px 25px;
            border-radius: 4px;
            text-decoration: none;
            transition: all 0.3s;
        }
        .continue-shopping-btn:hover {
            background: #ff4a4a;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(214, 81, 6, 0.3);
        }
        .cart-table {
            width: 100%;
            border-collapse: collapse;
        }
        .cart-table th {
            background-color: #f8f9fa;
            padding: 15px;
            text-align: left;
            border-bottom: 2px solid #dee2e6;
            font-weight: 600;
            color: #666;
        }
        .cart-table td {
            padding: 15px;
            border-bottom: 1px solid #eee;
            vertical-align: middle;
        }
        .product-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 4px;
            border: 1px solid #eee;
        }
        .remove-item {
            color: #d65106;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
        }
        .remove-item:hover {
            color: #b54505;
            text-decoration: underline;
        }
        .summary-row {
            background-color: #f8f9fa;
            font-weight: 600;
        }
        .summary-row td {
            padding: 15px;
            border-top: 2px solid #dee2e6;
            border-bottom: 2px solid #dee2e6;
        }
        .cart-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
            flex-wrap: wrap;
        }
        .cart-btn {
            background: #F34949;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 4px;
            font-weight: 600;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
            margin: 5px 0;
        }
        .cart-btn:hover {
            background: #b54505;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(214, 81, 6, 0.3);
        }
        .cart-btn.secondary {
            background: #6c757d;
        }
        .cart-btn.secondary:hover {
            background: #5a6268;
        }
        @media (max-width: 768px) {
            .cart-table {
                display: block;
                overflow-x: auto;
            }
            .cart-actions {
                flex-direction: column;
            }
            .cart-btn {
                width: 100%;
                text-align: center;
                margin: 5px 0;
            }
        }
    </style>
</head>
<body data-spy="scroll" class="static-layout">
    <?php include('navigation.php'); ?>
    <div id="side-nav" class="sidenav">
        <a href="javascript:void(0)" id="side-nav-close">&times;</a>
        
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
        <!-- Shopping Cart Section -->
        <section id="gtco-shopping-cart" class="section-padding shopping-cart-section">
            <div class="container">
                <div class="shopping-cart-container">
                    <h2 class="cart-title">Your Shopping Bag</h2>
                    
                    <?php if (!isset($_SESSION['ShoppingCartFunctions'])): ?>
                        <div class="empty-cart">
                            <p class="empty-cart-message">Your shopping cart is empty</p>
                            <a href='menu2.php' class="continue-shopping-btn">Continue Shopping</a>
                        </div>
                    <?php else: ?>
                        <form action="Shopping_Cart.php" method="GET">
                            <table class="cart-table">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Subtotal</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $size=count($_SESSION['ShoppingCartFunctions']);
                                    for ($i=0; $i < $size; $i++) { 
                                        $Product_Image_1=$_SESSION['ShoppingCartFunctions'][$i]['ProductImage'];
                                        $Product_ID=$_SESSION['ShoppingCartFunctions'][$i]['ProductID'];
                                        $Product_Name=$_SESSION['ShoppingCartFunctions'][$i]['ProductName'];
                                        $Product_Amount=$_SESSION['ShoppingCartFunctions'][$i]['ProductPrice'];
                                        $BuyQty=$_SESSION['ShoppingCartFunctions'][$i]['BuyQty'];
                                        $subTotal=$_SESSION['ShoppingCartFunctions'][$i]['ProductPrice']*$_SESSION['ShoppingCartFunctions'][$i]['BuyQty'];
                                    ?>
                                    <tr>
                                        <td><img src='<?php echo $Product_Image_1; ?>' alt='<?php echo $Product_Name; ?>' class="product-image"></td>
                                        <td>
                                            <strong><?php echo $Product_Name; ?></strong><br>
                                            <small>ID: <?php echo $Product_ID; ?></small>
                                        </td>
                                        <td>$<?php echo number_format($Product_Amount, 2); ?></td>
                                        <td><?php echo $BuyQty; ?></td>
                                        <td>$<?php echo number_format($subTotal, 2); ?></td>
                                        <td><a href='Shopping_Cart.php?ProductID=<?php echo $Product_ID; ?>&Action=Remove' class="remove-item">Remove</a></td>
                                    </tr>
                                    <?php } ?>
                                    <tr class="summary-row">
                                        <td colspan="5" align="right">Sub-Total:</td>
                                        <td>$<?php echo number_format(CalculateTotalAmount(), 2); ?></td>
                                    </tr>
                                    <tr class="summary-row">
                                        <td colspan="5" align="right">VAT (5%):</td>
                                        <td>$<?php echo number_format(CalculateVAT(), 2); ?></td>
                                    </tr>
                                    <tr class="summary-row">
                                        <td colspan="5" align="right"><strong>Grand Total:</strong></td>
                                        <td><strong>$<?php echo number_format(CalculateTotalAmount() + CalculateVAT(), 2); ?></strong></td>
                                    </tr>
                                </tbody>
                            </table>
                            
                            <div class="cart-actions">
                                <a href="Shopping_Cart.php?Action=ClearAll" class="cart-btn secondary">Clear Cart</a>
                                <div>
                                    <a href="menu2.php" class="cart-btn secondary">Continue Shopping</a>
                                    <a href="Checkout.php" class="cart-btn">Proceed to Checkout</a>
                                </div>
                            </div>
                        </form>
                    <?php endif; ?>
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
    <script src="https://cdn.rawgit.com/noelboss/featherlight/1.7.13/release/featherlight.min.js"></script>
    <script src="vendor/stellar/jquery.stellar.js" type="text/javascript" charset="utf-8"></script>

    <!-- Main JS -->
    <script src="js/app.min.js "></script>
</body>
</html>