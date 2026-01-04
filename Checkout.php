<?php 
session_start();
include('dbconnect.php');
include('Shopping_Cart_Functions.php');
include('autoid.php');

if(!isset($_SESSION['cid'])) {
    echo "<script>window.alert('Please Login First')</script>";
    echo "<script>window.location='login.php'</script>";
    exit();
} else {
    $customer_ID=$_SESSION['cid'];
    $query="SELECT * From Customer WHERE CustomerID='$customer_ID'";
    $ret=mysqli_query($connection,$query);
    $row=mysqli_fetch_array($ret);
}

if (isset($_POST['btnConfirm'])) {
    $rdoDeliveryType=$_POST['rdoDeliveryType'];
    if($rdoDeliveryType == 1) {
        $Address=$_POST['txtAddress'];
        $Phone=$_POST['txtPhone'];
    } else {
        $CID=$_SESSION['CustomerID'];
        $select= "SELECT * FROM Customer WHERE CustomerID='$CID'";
        $query=mysqli_query($connection,$select);
        $data=mysqli_fetch_array($query);
        $Address=$data['Address'];
        $Phone=$data['Phone'];
    }

    $Customer_ID=$_SESSION['cid'];
    $Status="Paid";
    $txtOrderID=$_POST['txtOrderID'];
    $txtOrderDate=$_POST['txtOrderDate'];
    $txtTotalamount=$_POST['txtTotalamount'];
    $txtVAT=$_POST['txtVAT'];
    $txtGrandTotal=$_POST['txtGrandTotal'];
    $txtTotalQuantity=$_POST['txtTotalQuantity'];
    $txtRemark=$_POST['txtRemark'];
    $rdoPaymentType=$_POST['rdoPaymentType'];

    $Orderquery="INSERT INTO Orders
                (Order_ID, Order_Date, CustomerID, Order_Total_Amount, Tax, All_Total, Order_quantity, Remark, Payment_Type, Order_Location, Order_Phone, Order_Status)
                VALUES
                ('$txtOrderID', '$txtOrderDate', '$Customer_ID', '$txtTotalamount', '$txtVAT', '$txtGrandTotal', '$txtTotalQuantity', ' $txtRemark', '$rdoPaymentType', '$Address', '$Phone', '$Status')";
    $result=mysqli_query($connection,$Orderquery);

    $size= count($_SESSION['ShoppingCartFunctions']);
    for($i=0; $i < $size ; $i++) { 
       $ProductID=$_SESSION['ShoppingCartFunctions'][$i]['ProductID'];
       $BuyQty=$_SESSION['ShoppingCartFunctions'][$i]['BuyQty'];
       $Product_Amount=$_SESSION['ShoppingCartFunctions'][$i]['ProductPrice'];

       $ODquery = "INSERT INTO orderdetail
                (Order_ID, ProductID, UnitPrice, BuyQty)
                VALUES
                ('$txtOrderID','$ProductID', '$Product_Amount', '$BuyQty')";
       $result=mysqli_query($connection,$ODquery);
    }

    if($result) {
        unset($_SESSION['ShoppingCartFunctions']);
        echo "<script>window.alert('Checkout Process Complete. Your Order is placed')</script>";
        echo "<script>window.location='menu2.php'</script>";
    } else {
        echo "<p>Something Went Wrong in CheckOut" .mysqli_error($connection) ."</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Checkout - The Urban Brew</title>
    <meta name="description" content="Complete Your Purchase">
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
       section{
        background-color: #fafafa !important;
       }
        .qr{
            border: 10px solid #1d6fb5;
        }
        #length{
            min-height: 100px;
        }
        .checkout-section {
            padding: 60px 0;
        }
        .checkout-container {
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            padding: 30px;
            margin-bottom: 30px;
        }
        .section-title {
            font-size: 1.5rem;
            margin-bottom: 20px;
            color: #333;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }
        fieldset {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 20px;
            margin-bottom: 30px;
        }
        legend {
            width: auto;
            padding: 0 10px;
            font-size: 1.2rem;
            color: #d65106;
            font-weight: 600;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
        }
        .info-table td {
            padding: 12px 5px;
            border-bottom: 1px solid #eee;
        }
        .info-table tr:last-child td {
            border-bottom: none;
        }
        .form-control {
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 8px 12px;
            width: 100%;
            max-width: 300px;
        }
        textarea.form-control {
            min-height: 100px;
        }
        select.form-control {
            height: 38px;
        }
        .radio-group {
            margin: 15px 0;
        }
        .radio-group label {
            margin-right: 20px;
            cursor: pointer;
        }
        .btn {
            background: #F34949 !important;
            color: white !important;
            border: none;
            padding: 12px 25px;
            border-radius: 4px;
            font-weight: 600;
            transition: all 0.3s;
            cursor: pointer;
            margin-right: 10px;
        }
        .btn:hover {
            background: #b54505;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(214, 81, 6, 0.3);
        }
        .btn-secondary {
            background: #6c757d !important;
            text-decoration: none;
            display: inline-block;
            line-height: 38px;
        }
        .btn-secondary:hover {
            background: #5a6268;
        }
        .cart-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
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
        .summary-row {
            background-color: #f8f9fa;
            font-weight: 600;
        }
        .summary-row td {
            padding: 15px;
            border-top: 2px solid #dee2e6;
            border-bottom: 2px solid #dee2e6;
        }
        #PaymentTable, #AddressTable {
            width: 100%;
            margin-top: 15px;
            visibility: visible;
            border-collapse: collapse;
            border: 2px solid lightblue;
        }
        #PaymentTable td, #AddressTable td {
            padding: 10px 0;
        }
        small {
            color: #666;
            font-size: 0.8rem;
        }
        @media (max-width: 768px) {
            .checkout-container {
                padding: 15px;
            }
            fieldset {
                padding: 15px;
            }
            .form-control {
                max-width: 100%;
            }
            .btn {
                width: 100%;
                margin-bottom: 10px;
            }
        }
    </style>
    <script type="text/javascript">
        function showPaymentTable() {
            document.getElementById('PaymentTable').style.display="table";
        }
        function hidePaymentTable() {
            document.getElementById('PaymentTable').style.display="none";
        }
        function showQR() {
            document.getElementById('QRPayment').style.display="table";
        }
        function hideQR() {
            document.getElementById('QRPayment').style.display="none";
        }
        function showAddress() {
            document.getElementById('AddressTable').style.display="table";
        }
        function hideAddress() {
            document.getElementById('AddressTable').style.display="none";
        }
        window.onload = function() {          
            if(document.querySelector('input[name="rdoPaymentType"][value="QR"]').checked) {
                hidePaymentTable();
            }
            if(document.querySelector('input[name="rdoDeliveryType"][value="2"]').checked) {
                hideAddress();
            }
        }
    </script>
</head>
<body data-spy="scroll" class="static-layout">
    <?php include('navigation.php'); ?>
    <div class="cover">
    <div class="boxed-page">
        <!-- Checkout Section -->
        <section id="gtco-checkout" class="section-padding checkout-section">
            <div class="container">
                <div class="checkout-container">
                    <h2 class="section-title">Checkout</h2>
                    
                    <form action="Checkout.php" method="POST">
                        <!-- (1) Customer Personal Data -->
                        <fieldset>
                            <legend>1. Customer Information</legend>
                            <table class="info-table">
                                <tr>
                                    <td width="30%">Customer Name</td>
                                    <td><strong><?php echo $row['CustomerFirstName'] ?></strong></td>
                                </tr>
                                <tr>
                                    <td>Phone</td>
                                    <td><strong><?php echo $row['CustomerPhone'] ?></strong></td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td><strong><?php echo $row['CustomerEmail'] ?></strong></td>
                                </tr>
                                <tr>
                                    <td>Address</td>
                                    <td><strong><?php echo $row['CustomerAddress'] ?></strong></td>
                                </tr>
                            </table>
                        </fieldset>

                        <!-- (2) Order Information -->
                        <fieldset>
                            <legend>2. Order Details</legend>
                            <table class="info-table">
                                <tr>
                                    <td width="30%">Order Number</td>
                                    <td>
                                        <input type="text" class="form-control" name="txtOrderID" value="<?php echo AutoID('Orders', 'Order_ID', 'ORD-', 4) ?>" readonly/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Order Date</td>
                                    <td>
                                        <input type="text" class="form-control" name="txtOrderDate" value="<?php echo date('Y-m-d') ?>" readonly/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Order Total Amount: £</td>
                                    <td>
                                        <input type="number" class="form-control" name="txtTotalamount" value="<?php echo CalculateTotalAmount() ?>" readonly/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>VAT (5%): £</td>
                                    <td>
                                        <input type="number" class="form-control" name="txtVAT" value="<?php echo CalculateVAT() ?>" readonly/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Grand Total: £</td>
                                    <td>
                                        <input type="number" class="form-control" name="txtGrandTotal" value="<?php echo CalculateTotalAmount()+CalculateVAT() ?>" readonly/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Total Quantity</td>
                                    <td>
                                        <input type="number" class="form-control" name="txtTotalQuantity" value="<?php echo CalculateTotalQuantity() ?>" readonly/> pcs
                                    </td>
                                </tr>
                                <tr>
                                    <td>Remark</td>
                                    <td>
                                        <textarea type="text" id='length'class="form-control" name="txtRemark" placeholder="Any specifications, less sugar, no milk,..." ></textarea>
                                    </td>
                                </tr>
                            </table>
                        </fieldset>

                        <!-- (3) Payment Section -->
                        <fieldset>
                            <legend>3. Payment Method</legend>
                            <div class="radio-group">
                                <label>
                                    <input type="radio" name="rdoPaymentType" value="QR" onclick="showQR(), hidePaymentTable()" checked/> QR PromptPay
                                </label>
                                <label>
                                    <input type="radio" name="rdoPaymentType" value="VISA" onclick="showPaymentTable(), hideQR()"/> Card
                                </label>
                                <label>
                                    <input type="radio" name="rdoPaymentType" value="COD" onclick="hidePaymentTable(), hideQR()"/> Cash
                                </label>
                            </div>
                            <div id="QRPayment" name="QRPayment">
                                <p>Scan for Payment</p>
                                <img src="img/qr.png" class="qr">
                            </div>
                            <table id="PaymentTable" name="PaymentTable">
                                <tr>
                                    <td>
                                        <div style="max-width: 400px;">
                                            <div class="form-group">
                                                <label>Name <small>(as it appears on your card)</small></label>
                                                <input type="text" class="form-control" name="txtNameOnCard" placeholder="Enter Your Name..."/>
                                            </div>
                                            <div class="form-group">
                                                <label>Card Number <small>(no dashes or spaces)</small></label>
                                                <input type="text" class="form-control" name="txtCardNumber" placeholder="Enter card number..."/>
                                            </div>
                                            <div class="form-group">
                                                <label>Expiration Date <small>(no dashes or spaces)</small></label>
                                                <div style="display: flex; gap: 10px;">
                                                    <select name="cboMonth" class="form-control">
                                                        <option>Month</option>
                                                        <option>January</option>
                                                        <option>February</option>
                                                        <option>March</option>
                                                        <option>April</option>
                                                        <option>May</option>
                                                        <option>June</option>
                                                        <option>July</option>
                                                        <option>August</option>
                                                        <option>September</option>
                                                        <option>October</option>
                                                        <option>November</option>
                                                        <option>December</option>
                                                    </select>
                                                    <select name="cboYear" class="form-control">
                                                        <option>Year</option>
                                                        <option>2025</option>
                                                        <option>2026</option>
                                                        <option>2027</option>
                                                        <option>2028</option>
                                                        <option>2029</option>
                                                        <option>2030</option>
                                                        <option>2031</option>
                                                        <option>2032</option>
                                                        <option>2033</option>
                                                        <option>...</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Security Code <small>(3 on Back, Amex 4 on front)</small></label>
                                                <input type="number" class="form-control" name="txtsecuritycode" placeholder="Enter security code" >
                                            </div>
                                        </div>
                                    </td>
                                </tr> 
                            </table>
                        </fieldset>

                        <!-- (4) Delivery Details -->
                        <fieldset>
                            <legend>4. Delivery Information</legend>
                            <div class="radio-group">
                                <label>
                                    <input type="radio" name="rdoDeliveryType" value="1" onclick="showAddress()" checked/> Different Address
                                </label>
                                <label>
                                    <input type="radio" name="rdoDeliveryType" value="2" onclick="hideAddress()"/> Same as Account Address
                                </label>
                            </div>
                            
                            <table id="AddressTable" name="AddressTable">
                                <tr>
                                    <td>
                                        <div style="max-width: 400px;">
                                            <div class="form-group">
                                                <label>Delivery Phone</label>
                                                <input type="text" class="form-control" name="txtPhone" placeholder="Enter phone number">
                                            </div>
                                            <div class="form-group">
                                                <label>Delivery Address</label>
                                                <textarea class="form-control" name="txtAddress" placeholder="Enter delivery address"></textarea>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            
                            <div style="margin-top: 20px;">
                                <button type="submit" name="btnConfirm" class="btn">Confirm Order</button>
                                <a href="menu2.php" class="btn btn-secondary">Continue Shopping</a>
                            </div>
                        </fieldset>

                        <!-- (5) Order Summary -->
                        <fieldset>
                            <legend>5. Order Summary</legend>
                            <?php if (!isset($_SESSION['ShoppingCartFunctions'])): ?>
                                <div style="text-align: center; padding: 20px;">
                                    <p>Shopping Cart is Empty</p>
                                    <a href="menu2.php" class="btn btn-secondary">Continue Shopping</a>
                                </div>
                            <?php else: ?>
                                <table class="cart-table">  
                                    <thead>
                                        <tr>
                                            <th>Image</th>
                                            <th>Product ID</th>
                                            <th>Product Name</th>
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
                                                $subTotal=$Product_Amount * $BuyQty;
                                        ?>
                                        <tr>
                                            <td><img src="<?php echo $Product_Image_1; ?>" class="product-image"></td>
                                            <td><?php echo $Product_ID; ?></td>
                                            <td><?php echo $Product_Name; ?></td>
                                            <td><?php echo $Product_Amount; ?> £</td>
                                            <td><?php echo $BuyQty; ?></td>
                                            <td><?php echo $subTotal; ?> £</td>
                                            <td><a href="Shopping_Cart.php?ProductID=<?php echo $Product_ID; ?>&Action=Remove" style="color: #d65106;">Remove</a></td>
                                        </tr>
                                        <?php } ?>
                                        <tr class="summary-row">
                                            <td colspan="6" align="right">Sub-Total:</td>
                                            <td><b><?php echo CalculateTotalAmount(); ?> £</b></td>
                                        </tr>
                                        <tr class="summary-row">
                                            <td colspan="6" align="right">VAT (5%):</td>
                                            <td><b><?php echo CalculateVAT(); ?> £</b></td>
                                        </tr>
                                        <tr class="summary-row">
                                            <td colspan="6" align="right">Grand Total:</td>
                                            <td><b><?php echo CalculateTotalAmount() + CalculateVAT(); ?> £</b></td>
                                        </tr>
                                    </tbody>
                                </table>
                            <?php endif; ?>
                        </fieldset>
                    </form>
                </div>
            </div>
        </section>
</div>
        <!-- Footer -->
        <?php include('footer.php'); ?>
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