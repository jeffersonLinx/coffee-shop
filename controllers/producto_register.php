<?php
session_start();
require_once "../config/conn.php";

if (!empty($_POST)) {
    $nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
    $cantidad = (int)$_POST['cantidad'];
    $descripcion = mysqli_real_escape_string($conn, $_POST['descripcion']);
    $precio_normal = (float)$_POST['p_normal'];
    $precio_rebajado = (float)$_POST['p_rebajado'];
    $categoria = (int)$_POST['categoria'];

    $img = $_FILES['foto'];
    $name = $img['name'];
    $tmpname = $img['tmp_name'];
    $fecha = date("YmdHis");
    $foto = $fecha . ".jpg";
    $destino = "../assets/img/" . $foto;

    if (move_uploaded_file($tmpname, $destino)) {
        $query = mysqli_query($conn, "INSERT INTO productos (nombre, descripcion, precio_normal, precio_rebajado, cantidad, imagen, id_categoria) 
        VALUES ('$nombre', '$descripcion', '$precio_normal', '$precio_rebajado', '$cantidad', '$foto', '$categoria')");
        
        if ($query) {
            $_SESSION['alert_producto'] = 'Producto registrado exitosamente';
        } else {
            $_SESSION['alert_producto'] = 'Error al registrar producto';
        }
    } else {
        $_SESSION['alert_producto'] = 'Error al subir la imagen';
    }
}
header('Location: ../admin/productos.php');
exit;
?>
