<?php
    $host=  "localhost";
    $user= "root";
    $clave= "";
    $bd=  "CoffeeShop"; 
    $conn = mysqli_connect($host, $user, $clave, $bd);
    if (mysqli_connect_errno())
    {   
        echo "conexion exitorsa";
        exit();
    }
    mysqli_select_db($conn,$bd) or die("No se encuentra la base de datos");
    mysqli_set_charset($conn,"utf8");

    // if ($conn)
    // {
    //     echo "conexion exitosa";
    // }
    // else 
    // {
    //     echo "conexion no exitosa";
    // }
?>