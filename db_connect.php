<?php
    $server = "localhost";
    $username = "root";
    $password = "";
    $db = "bd_teamup";

    $conn = mysqli_connect($server,$username,$password,$db);

    if($conn->connect_error){
        die('Erreur : ' .$conn->connect_error);
    }

?>