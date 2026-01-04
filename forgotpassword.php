<?php include('dbconnect.php');
include('connections.php'); 

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>The Urban Brew: Password Reset</title>
	<style type="text/css">
		.passwordform{
			padding: 40px;
			box-shadow: 4px 4px 5px #bababa;
			border-radius: 20px;
		}
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
            width: 420px;
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

<div class="back">

		<div class="login-form">
        <h2>Password Reset</h2>
        <form action="forgotpassword_function.php" method="POST">
            <div class="form-group">
                <label for="txtemail">Email</label>
                <input type="email" class="form-control" id="txtemail" name="email" placeholder="Enter your email" required>
            </div>
<br>
            <div class="row">
                <div class="col-md-12">
                    <button type="submit" name="btnlogin" class="btn-login">Send Confirmation</button>
                </div>
            </div>
        </form>
    </div>
	</div>

<?php include('footer.php'); ?>
</body>
</html>