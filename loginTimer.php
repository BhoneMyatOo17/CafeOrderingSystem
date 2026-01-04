<?php session_start();
include('connections.php');
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Timer</title>    
    <link rel="stylesheet" type="text/css" href="css/style.css?<?php echo time(); ?>" />
    <link rel="icon" type="image/png" href="image/weblogo.png">
</head>
<body>
    <?php include('navigation.php');?>
    <hr>
<div class="back">
    <hr>
    <div class="timer">
    <div id="Timer"></div>
    </div>
</div>
</div>
<style type="text/css">
    .back{
        padding: 30px;
        display: flex;
        text-align: center;
        align-items: center;
        justify-content: center;
    }
    .timer{
        padding: 80px;
        border-radius: 20px;
        border: 2px solid #F34949;
    }
</style>
    <script>
    var month = new Date().getMonth() + 1;   
    var day = new Date().getDate();
    var year = new Date().getFullYear();
    var hour = new Date().getHours();
    var minutes = new Date().getMinutes() + 1;
    var second = new Date().getSeconds() + 2;
    var time = hour + ":" + minutes + ":" + second;
    var ResetTime = new Date(month + " " + day + ", " + year + " " + time).getTime();


    var x = setInterval(function() {
     
        var now = new Date().getTime(); 
        var distance = ResetTime - now; 
       
        var minutes = Math.floor((distance % (1000 * 60 * 60 * 100)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        document.getElementById("Timer").innerHTML = "<h1>Login is blocked</h1>" + minutes + "m " + seconds + "s ";
       

        if (distance < 0) {
            clearInterval(x);
            document.getElementById("Timer").innerHTML = "<?php session_destroy();  ?>";
            window.location = 'login.php';
        }
    }, 1000);//1 sec = 1000 milisecond
    </script>
<?php include('footer.php');?>
</body>

</html>