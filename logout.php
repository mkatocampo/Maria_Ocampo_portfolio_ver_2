<?php
$pageTitle ="Logout";
//four steps to closing a session (logging out)

#1 - Find the session
include "includes/session.php";
include "includes/dbFunctions.php";

#2 - Unset all the session variables
$_SESSION = array(); //clear all sessions

#3 - Destroy the session cookie
if(isset($_COOKIE[session_name()])){
    setcookie(session_name(),'',time()-42000,'/');
}
 
#4 - Destroy the session
session_destroy();
redirectTo("login.php?logout=1");
