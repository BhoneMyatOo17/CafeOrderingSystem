<?php include('dbconnect.php');
 include('autoid.php'); 

include('dbconnect.php');

if (isset($_POST['submit'])) {
    $productID = $_POST['product_id'];
    $productName = $_POST['product_name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $productTypeID = $_POST['product_type'];
    $fileproductImage1=$_FILES['product_image']['name'];
    $folder="uploads/";
    $FileName1=$folder. '_' . $fileproductImage1;
    $copy=copy($_FILES['product_image']['tmp_name'],$FileName1);
    if(!$copy)
    {
        echo "<p>Cannot Copy Image</p>";
        exit();
    }
        
              
                $query = "INSERT INTO Product (ProductID, ProductName, ProductPrice, ProductDescription,ProductImage, ProductTypeID )
                          VALUES ('$productID', '$productName', '$price', '$description', '$FileName1','$productTypeID')";

                if (mysqli_query($connection, $query)) {
                    echo "<script type='text/javascript'>
                            alert('Product Registered Successfully');
                            window.location.href = 'productregister.php';
                          </script>";
                } else {
                    echo "<script type='text/javascript'>
                            alert('Error: " . mysqli_error($connection) . "');
                          </script>";
                }
            }

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Product Registration Form</title>
    <link rel="icon" type="image/png" href="img/weblogo.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php include('adminnavigation.php'); ?>
    <div class="registration-form">
        <h2>Product Registration</h2>
        <form action="productregister.php" method="post" enctype="multipart/form-data">
            <!-- Product ID -->
            <div class="form-group">
                <label for="product_id">Product ID</label>
                <input type="text" class="form-control" id="product_id" name="product_id" required value="<?php echo AutoID("Product", "ProductID", "P-", 4); ?>" readonly>
            </div>

            <!-- Product Name -->
            <div class="form-group">
                <label for="product_name">Product Name</label>
                <input type="text" class="form-control" id="product_name" name="product_name" placeholder="Enter Product Name" required>
            </div>

            <!-- Price -->
            <div class="form-group">
                <label for="price">Price</label>
                <input type="text" class="form-control" id="price" name="price" placeholder="Enter Price" required>
            </div>

            <!-- Description -->
            <div class="form-group">
                <label for="description">Product Description</label>
                <input type="text" class="form-control" id="description" name="description" placeholder="Enter Product Description" required>
            </div>

            <!-- Product Type Select Menu -->
            <div class="form-group">
                <label for="product_type">Product Type</label>
                <select class="form-control2" name="product_type" required>
                      <option>Choose Product Type</option>
            <?php
 
                $query="SELECT * FROM producttype";
                $run=mysqli_query($connection, $query);
                $count=mysqli_num_rows($run);
 
                for ($i=0; $i <$count ; $i++)
                { 
                    $row=mysqli_fetch_array($run);
                    $typeid=$row['ProductTypeID'];
                    $type=$row['ProductTypeName'];
 
                    echo "<option value='$typeid'>$type</option>";
                }
                 ?>
                </select>
            </div>

            <!-- Product Image Upload -->
            <div class="form-group">
                <label for="product_image">Product Image</label>
                <input type="file" name="product_image" accept="image/*" required>
            </div>
            <br>

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
        <h2>Registered Tables</h2>
        <div class="table-list">
             <?php
    if (isset($_GET['delete_id'])) {
        $delete_id = $_GET['delete_id'];
        $delete_query = "DELETE FROM Product WHERE ProductID = '$delete_id'";
        mysqli_query($connection, $delete_query);
    }

    $query = "SELECT * FROM Product";
            $result = mysqli_query($connection, $query);


    if ($result && mysqli_num_rows($result) > 0) {
        echo "<table>
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Product Price</th>
                        <th>Description</th>
                        <th>Deletion</th>
                    </tr>
                </thead>
                <tbody>";

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$row['ProductName']}</td>
                    <td>{$row['ProductPrice']}</td>
                    <td>{$row['ProductDescription']}</td>
                    <td>
                        <a href='?delete_id={$row['ProductID']}' onclick=\"return confirm('Are you sure you want to remove this Product?');\">Remove</a>
                    </td>
                  </tr>";
        }

        echo "</tbody></table>";
    } else {
        echo "<p>No Product found in the database.</p>";
    }
    ?>
        </div>
    </div>
 <?php include('footer.php'); ?>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
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
        body {
            font-family: 'Open Sans', sans-serif;
            background-color: #F4EDE5;
            color: #333;
        }

        .registration-form {
            background: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
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

        .form-control2 {
            border-radius: 5px;
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 20px;
            font-size: 1rem;
            color: #666;
        }

        .form-control2:focus {
            border-color: #636363;
            box-shadow: none;
        }

        .form-control2::placeholder {
            color: #999;
            opacity: 1;
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

        @media (max-width: 576px) {
            .registration-form {
                padding: 20px;
                margin-top: 106px;
            }

            .registration-form h2 {
                font-size: 1.5rem;
            }
        }
    </style>
</body>
</html>