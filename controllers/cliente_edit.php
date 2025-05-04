<?php
require_once "../config/conn.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $nombre = trim($_POST['nombre']);
    $correo = trim($_POST['correo']);

    if ($id && $nombre && $correo) {
        $query = "UPDATE clientes SET nombre = ?, correo = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ssi", $nombre, $correo, $id);
        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['alert_producto'] = "Cliente actualizado correctamente.";
        } else {
            $_SESSION['alert_producto'] = "Error al actualizar el cliente.";
        }
    } else {
        $_SESSION['alert_producto'] = "Campos incompletos.";
    }
    header("Location: ../admin/clientes.php");
    exit();
}
?>
