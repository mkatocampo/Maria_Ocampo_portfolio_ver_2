<?php
    $hostname = "localhost";
    $username = "dev";
    $password = "dev1234";
    $dbName = "maria_ocampo_portfolio";

    $conn = new mysqli($hostname,$username,$password,$dbName);

    if($conn->connect_error){
        die("Connection failed". $conn->connect_error);
    }
?>