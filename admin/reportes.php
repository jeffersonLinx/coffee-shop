<?php
session_start();
require_once "../config/conn.php"; // Asegúrate de que esta línea esté correcta y apunte al archivo de conexión

include("includes/header.php");

// Verificar si el usuario es admin
if ($_SESSION['rol'] != 'admin') {
    echo "<script>alert('Acceso denegado: No tienes permisos esta seccion.'); window.location.href = 'productos.php';</script>";
    exit();
}
?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">DASHBOARD</h1>
</div>

<H1> REPORTES DASBOARD</H1>

<?php include("includes/footer.php"); ?>
