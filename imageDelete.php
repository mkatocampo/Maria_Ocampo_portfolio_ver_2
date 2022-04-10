<?php
$pageTitle="Delete Image";
include "includes/session.php";
include "includes/dbFunctions.php";
include "includes/dbConnection.php";
include "includes/header.php";


if(isset($_SESSION['username'])){
    $id;
    $imageId;
    $type;

    if(isset($_GET['type']) && isset($_GET['id']) && isset($_GET['imageId'])){

        $type = $_GET['type'];
        $id = $_GET['id'];
        $imageId = $_GET['imageId'];

        if ($type=="proj"){
            deleteImage($conn,$imageId);
            redirectTo("projEdit.php?id=$id&type=blog");
        }else if ($type=="blog"){
            deleteImage($conn,$imageId);
            redirectTo("blogEdit.php?id=$id&type=proj");
        }
    }
}else{
    redirectTo("login.php?message=failed");
}