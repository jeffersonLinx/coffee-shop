<?php
session_start();
require_once "../config/conn.php";

// Verificar si hay un ID de producto
if (isset($_POST['id_producto'])) {
    $id_producto = $_POST['id_producto'];

    // Consultar el estado actual del producto
    $query = mysqli_query($conn, "SELECT estado FROM productos WHERE id = '$id_producto'");
    $data = mysqli_fetch_assoc($query);

    if ($data) {
        // Cambiar el estado (si es 1, poner en 0, y viceversa)
        $nuevo_estado = ($data['estado'] == 1) ? 0 : 1;

        // Actualizar el estado en la base de datos
        $update_query = mysqli_query($conn, "UPDATE productos SET estado = '$nuevo_estado' WHERE id = '$id_producto'");

        if ($update_query) {
            // Si el producto está inactivo, inactivar también las reservas o acciones relacionadas
            if ($nuevo_estado == 0) {
                mysqli_query($conn, "UPDATE reservas SET estado = 0 WHERE id_producto = '$id_producto'");
            }

            // Redirigir a la página de productos con un mensaje de éxito
            $_SESSION['alert_producto'] = "Estado actualizado correctamente.";
        } else {
            $_SESSION['alert_producto'] = "Error al actualizar el estado.";
        }
    }
}

// Redirigir nuevamente a la página de productos
header("Location: ../admin/productos.php");
exit;
?>
