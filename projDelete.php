<?php
$pageTitle="Delete Project";
include "includes/session.php";
include "includes/dbFunctions.php";
include "includes/dbConnection.php";
include "includes/header.php";


if(isset($_SESSION['username'])){
    $id;

    if(isset($_GET['id'])){
        $id =$_GET['id'];
        deleteProj($conn,$id);
    }

    redirectTo('allProjs.php');

}else{
    redirectTo("login.php?message=failed");
}