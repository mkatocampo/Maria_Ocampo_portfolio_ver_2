<?php  session_start();

function confirmLoggedIn(){
    if(!isset($_SESSION['email'])){
        redirectTo('login.php');
    }
}