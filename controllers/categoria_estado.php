<?php
session_start();
require_once "../config/conn.php";

if (!empty($_POST)) {
    $id     = (int) $_POST['id'];
    $estado = (int) $_POST['estado'];

    // 1) Actualiza el estado de la categoría
    $query = mysqli_query($conn, 
        "UPDATE categorias SET estado = '$estado' WHERE id = $id"
    );

    if ($query) {
        // 2) Si la categoría se desactiva, cascada a productos
        if ($estado === 0) {
            mysqli_query($conn, 
                "UPDATE productos SET estado = 0 WHERE id_categoria = $id"
            );
            $_SESSION['alert_categoria'] = 'Categoría desactivada y productos relacionados inactivados.';
        } else {
            $_SESSION['alert_categoria'] = 'Categoría activada correctamente.';
        }
    } else {
        $_SESSION['alert_categoria'] = 'Error al actualizar el estado de la categoría.';
    }
}

header('Location: ../admin/categorias.php');
exit;
