<?php
session_start();
require_once "../config/conn.php";

if (!empty($_POST)) {
    // Obtener datos del formulario
    $producto_id = (int)$_POST['producto_id'];
    $nuevo_estado = (int)$_POST['nuevo_estado'];  // Este es el nuevo estado del producto

    // Obtener el id_categoria del producto
    $producto_query = mysqli_query($conn, "SELECT id_categoria FROM productos WHERE id = $producto_id");
    $producto_data = mysqli_fetch_assoc($producto_query);

    if ($producto_data) {
        $categoria_id = $producto_data['id_categoria'];

        // Verificar si la categoría está activa (estado = 1)
        $categoria_query = mysqli_query($conn, "SELECT estado FROM categorias WHERE id = $categoria_id");
        $categoria_data = mysqli_fetch_assoc($categoria_query);

        if ($categoria_data && $categoria_data['estado'] == 0) {
            // Si la categoría está inactiva, no se puede cambiar el estado del producto
            $_SESSION['alert_producto'] = 'No se puede cambiar el estado de este producto, ya que la categoría está inactiva.';
        } else {
            // Si la categoría está activa, actualizar el estado del producto
            $update_query = mysqli_query($conn, "UPDATE productos SET estado = $nuevo_estado WHERE id = $producto_id");
            if ($update_query) {
                $_SESSION['alert_producto'] = 'Estado del producto actualizado exitosamente.';
            } else {
                $_SESSION['alert_producto'] = 'Error al actualizar el estado del producto.';
            }
        }
    } else {
        $_SESSION['alert_producto'] = 'Producto no encontrado.';
    }
}
header('Location: ../admin/productos.php');
exit;
?>
