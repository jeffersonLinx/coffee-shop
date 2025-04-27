<?php
session_start();
require_once "../config/conn.php";

if (!empty($_POST)) {
    $id = (int)$_POST['id'];
    $nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
    $cantidad = (int)$_POST['cantidad'];
    $descripcion = mysqli_real_escape_string($conn, $_POST['descripcion']);
    $precio_normal = (float)$_POST['p_normal'];
    $precio_rebajado = (float)$_POST['p_rebajado'];
    $categoria = (int)$_POST['categoria'];

    $query = mysqli_query($conn, "UPDATE productos SET nombre='$nombre', descripcion='$descripcion', precio_normal='$precio_normal', precio_rebajado='$precio_rebajado', cantidad='$cantidad', id_categoria='$categoria' WHERE id = $id");
    
    if ($query) {
        $_SESSION['alert_producto'] = 'Producto actualizado correctamente';
    } else {
        $_SESSION['alert_producto'] = 'Error al actualizar producto';
    }
}
header('Location: ../admin/productos.php');
exit;
?>
