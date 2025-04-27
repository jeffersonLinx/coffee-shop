<?php
session_start();
require_once "../config/conn.php";

if (!empty($_POST)) {
    $id = (int)$_POST['id'];
    $nombre = mysqli_real_escape_string($conn, $_POST['nombre']);

    $query = mysqli_query($conn, "UPDATE categorias SET nombre_categoria='$nombre' WHERE id=$id");
    
    if ($query) {
        $_SESSION['alert_categoria'] = 'Categoría actualizada exitosamente';
    } else {
        $_SESSION['alert_categoria'] = 'Error al actualizar categoría';
    }
}
header('Location: ../admin/categorias.php');
exit;
?>
