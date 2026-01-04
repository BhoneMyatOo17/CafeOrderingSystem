<?php session_start(); 
include('dbconnect.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>About Us: The Urban Brew</title>
    <meta name="description" content="Resto">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- External CSS -->
    <link rel="stylesheet" href="vendor/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="vendor/select2/select2.min.css">
    <link rel="stylesheet" href="vendor/owlcarousel/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdn.rawgit.com/noelboss/featherlight/1.7.13/release/featherlight.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/css/tempusdominus-bootstrap-4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.1/css/brands.css">

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700|Josefin+Sans:300,400,700">
    <link rel="stylesheet" href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

    <!-- CSS -->
    <link rel="stylesheet" href="css/style.min.css">
 <link rel="icon" type="image/png" href="img/weblogo.png">
    <!-- Modernizr JS for IE8 support of HTML5 elements and media queries -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.js"></script>
<style type="text/css">
    .content{
        padding: 40px;
    }
</style>
</head>
<body data-spy="scroll" data-target="#navbar">
	<div id="side-nav" class="sidenav">
	<a href="javascript:void(0)" id="side-nav-close">&times;</a>
	
	
</div>	<div id="side-search" class="sidenav">
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
	
 	
</div>	<div id="canvas-overlay"></div>
	<div class="boxed-page">
        <?php include('navigation.php') ?>
			<!-- Welcome Section -->
<section id="gtco-welcome" class="bg-white section-padding">
    <div class="container">
        <div class="section-content">
            <div class="row">
                <div class="col-sm-5 img-bg d-flex shadow align-items-center justify-content-center justify-content-md-end img-2" style="background-image: url(img/tubcafe.jpg);">
                    
                </div>
                <div class="col-sm-7 py-5 pl-md-0 pl-4">
                    <div class="heading-section pl-lg-5 ml-md-5">
                        <span class="subheading">
                            About Us
                        </span>
                        <h2>
                            Welcome to The Urban Brew
                        </h2>
                    </div>
                    <div class="pl-lg-5 ml-md-5">
                        <p>Welcome to The Urban Brew Cafe, your modern oasis in the heart of Silom, Bangkok. Since opening our doors in 2013, we’ve brewed more than just coffee — we’ve brewed community, creativity, and comfort.</p>

                        <p>What started as a small roadside coffee stall has transformed into a stylish, vibrant café that combines contemporary aesthetics with local charm. Inspired by Bangkok’s urban culture and the timeless love for a good cup of coffee, The Urban Brew is a place where locals and visitors come together to relax, connect, and enjoy.</p>

                     
                        <h3 class="mt-5">Special Recipe</h3>
                        <div class="row">
                            <div class="col-4">
                                <a href="menu2.php" class="thumb-menu">
                                    <img class="img-fluid img-cover" src="img/thai/padthai.png" />
                                    <h6>Signature Pad Thai</h6>
                                    <h7>See more</h7>
                                </a>
                            </div>
                            <div class="col-4">
                                <a href="menu2.php" class="thumb-menu">
                                    <img class="img-fluid img-cover" src="img/thai/thaitea.png" />
                                    <h6>Traditional Thai Tea</h6>
                                    <h7>See more</h7>
                                </a>
                            </div>
                            <div class="col-4">
                                <a href="menu2.php" class="thumb-menu">
                                    <img class="img-fluid img-cover" src="img/coffee/icecoffee.png"/>
                                    <h6>Best selling Ice coffee</h6>
                                    <h7>See more</h7>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content"><p>At The Urban Brew, we believe in innovation and tradition. While we still serve the comforting flavors you love, we’ve embraced technology to enhance your experience. From online ordering and QR code table service, to a loyalty system that rewards you with every visit, we’re dedicated to making every interaction smooth, fast, and satisfying.</p>

        <p>Our team is passionate, our coffee is strong, and our mission is simple — to serve moments worth savoring.</p>
        <br>
        <h2>Thank you for being part of our journey.</h2><br>
        Brewed for the moment. ☕
    </div><hr>
</section>
<!-- End of Welcome Section -->		
<?php include('footer.php'); ?>
</div>
	
</div>
	<!-- External JS -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
	<script src="vendor/bootstrap/popper.min.js"></script>
	<script src="vendor/bootstrap/bootstrap.min.js"></script>
	<script src="vendor/select2/select2.min.js "></script>
	<script src="vendor/owlcarousel/owl.carousel.min.js"></script>
	<script src="https://cdn.rawgit.com/noelboss/featherlight/1.7.13/release/featherlight.min.js"></script>
	<script src="vendor/stellar/jquery.stellar.js" type="text/javascript" charset="utf-8"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/js/tempusdominus-bootstrap-4.min.js"></script>

	<!-- Main JS -->
	<script src="js/app.min.js "></script>
</body>
</html>
