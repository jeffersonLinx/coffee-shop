<?php
    $host=  "localhost";
    $user= "root";
    $clave= "";
    $bd=  "CoffeeShop"; 
    $conexion = mysqli_connect($host, $user, $clave, $bd);
    if (mysqli_connect_errno())
    {   
        echo "conexion exitorsa";
        exit();
    }
    mysqli_select_db($conexion,$bd) or die("No se encuentra la base de datos");
    mysqli_set_charset($conexion,"utf8");

    // if ($conexion)
    // {
    //     echo "conexion exitosa";
    // }
    // else 
    // {
    //     echo "conexion no exitosa";
    // }
?>