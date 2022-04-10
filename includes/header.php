<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inconsolata&family=Nunito:wght@200&display=swap" rel="stylesheet">
    <title><?php echo $pageTitle; ?></title>
</head>
<body style="font-family: 'Inconsolata', monospace; font-size:larger; ">
    <nav class="navbar fixed-top justify-content-center" style="font-family: 'Lobster', cursive; font-size:x-large; text-shadow: -1px 1px 0 #000;">
        <a class="navbar-brand" href="#">
            <img src="assets/katlogo2.png" width="50" height="50" alt="">
        </a>
        <a class="nav-link" style="color: #fff;" href="index.php">Home</a>
        <a class="nav-link" style="color: #fff;" href="https://www.linkedin.com/in/ocampo-maria-katrina-9b1901151/">LinkedIn</a> 
        <a class="nav-link" style="color: #fff;" href="contact.php">Contact</a>
        <?php 
            if( isset($_SESSION['username']) || (!empty($_POST['username']) && validateLogin($conn,htmlentities($_POST['username']),htmlentities($_POST['password'])))){
                echo "<a class='nav-link' style='color: #fff;' href='logout.php'>Logout</a>";
            }else{
                echo "<a class='nav-link' style='color: #fff;' href='login.php'>Login</a>";
            }
        ?> 
    </nav>