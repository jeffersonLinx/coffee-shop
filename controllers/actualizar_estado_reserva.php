<?php
require_once "../config/conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_reserva = intval($_POST["id_reserva"]);
    $estado = $_POST["estado"];

    $estados_permitidos = ['pendiente', 'confirmada', 'cancelada'];

    if (in_array($estado, $estados_permitidos)) {
        $stmt = $conn->prepare("UPDATE reservas SET estado = ? WHERE id = ?");
        $stmt->bind_param("si", $estado, $id_reserva);
        $stmt->execute();
        $stmt->close();
    }

    $_SESSION['alert_producto'] = "Estado actualizado correctamente.";
} else {
    $_SESSION['alert_producto'] = "Error al intentar actualizar el estado.";
}
    // Redirige a la misma página desde la que se envió el formulario
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
// header("Location: ../admin/reserva.php");
// exit;
