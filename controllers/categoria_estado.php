<?php
session_start();
require_once "../config/conn.php";

if (!empty($_POST)) {
    $id = (int)$_POST['id'];
    $estado = (int)$_POST['estado'];

    $query = mysqli_query($conn, "UPDATE categorias SET estado='$estado' WHERE id=$id");

    if ($query) {
        if ($estado == 1) {
            $_SESSION['alert_categoria'] = 'Categoría activada correctamente';
        } else {
            $_SESSION['alert_categoria'] = 'Categoría desactivada correctamente';
        }
    } else {
        $_SESSION['alert_categoria'] = 'Error al actualizar el estado';
    }
}
header('Location: ../admin/categorias.php');
exit;
?>
