<?php
$pageTitle ="Login";
include "includes/session.php";   
include "includes/dbFunctions.php";
include "includes/dbConnection.php";
include "includes/header.php";
?>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

<section id="Blogs" style="box-sizing:border-box; width: 100%;  min-height: 100vh; background-color:#cfe9fe";>
<div style="padding:100px;">
    <h1 style="font-family: 'Lobster', cursive; color:#8e7f97">Log In</h1>
    <hr>

<?php
    ob_start();
    
    //if user is not logged in
    if(!isset($_SESSION['username']) && !isset($_SESSION['password']) && $_SERVER['REQUEST_METHOD'] !== "POST"){

        if(isset($_GET['logout'])){
            if($_GET['logout']==1){
                echo "You have been successfully logged out";
            }
        }
        if(!empty($_GET['message'])) {
            $message = $_GET['message'];
            echo "Missing Access Credential. User log in is required.";
        }   
    }

    //if user is already logged in
    else if((isset($_SESSION['username']) && isset($_SESSION['password'])) || $_SERVER['REQUEST_METHOD'] === "POST"){
    
        if(!empty($_POST['username']) && !empty($_POST['password'])){
            try{
                $username = htmlentities($_POST['username']);
                $password = htmlentities($_POST['password']);

                if(validateLogin($conn,$username, $password)){

                    $_SESSION['username'] = $username;
                    $_SESSION['password'] = $password;
                    redirectTo('home.php');
                }
                else{
                    echo "Invalid Username/Password.";
                }
            }catch(Exception $ex){
                echo "Error getting logged in! $ex->getMessage().";
            }
        }else{
            echo "Username/Password cannot be empty.";
        }
    }
?>
    <br><br>
    <form action='login.php' method='post'>
        <table>
            <tr>
                <td><label>Username:</label></td>
                <td><input type='text' name='username'/></td>
            </tr>

            <tr>
                <td><label>Password:</label></td>
                <td><input type='password' name='password'/></td>
            </tr>

        </table>
        <button type='submit' name='Login'>Login</button>
    </form>
</div>
</section>

<?php include "includes/footer.php"; ?>