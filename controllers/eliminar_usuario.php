<?php
session_start();
require_once "../config/conn.php"; // Asegúrate de que esta línea esté correcta

// Verificar si hay sesión iniciada y si el usuario es admin
if (!isset($_SESSION['id']) || $_SESSION['rol'] != 'admin') {
    echo "<script>alert('Acceso denegado: No tienes permisos para eliminar usuarios.'); window.location.href = '../index.php';</script>";
    exit();
}

if (isset($_GET['id'])) {
    $id_usuario = $_GET['id'];

    // Prevenir inyecciones SQL
    $id_usuario = mysqli_real_escape_string($conn, $id_usuario);

    // Eliminar usuario de la base de datos
    $query = "DELETE FROM usuarios WHERE id = '$id_usuario'";

    if (mysqli_query($conn, $query)) {
        header("Location: usuarios.php"); // Redirigir de nuevo a la lista de usuarios
        exit();
    } else {
        echo "Error al eliminar el usuario: " . mysqli_error($conn);
    }
}
?>
