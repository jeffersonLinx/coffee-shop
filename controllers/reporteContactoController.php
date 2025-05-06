<?php
require_once "../config/conn.php";

// Obtener parámetros de filtro
$filtroAnio = $_GET['anio'] ?? date('Y');
$busqueda = $_GET['busqueda'] ?? '';

// Consulta para mensajes
$sql = "SELECT nombre, correo, asunto, fecha_envio 
        FROM mensajes_contacto 
        WHERE YEAR(fecha_envio) = ?";

if (!empty($busqueda)) {
    $sql .= " AND (nombre LIKE ? OR correo LIKE ? OR asunto LIKE ?)";
}

$sql .= " ORDER BY fecha_envio DESC";

$stmt = $conn->prepare($sql);

if (!empty($busqueda)) {
    $paramBusqueda = "%$busqueda%";
    $stmt->bind_param("isss", $filtroAnio, $paramBusqueda, $paramBusqueda, $paramBusqueda);
} else {
    $stmt->bind_param("i", $filtroAnio);
}

$stmt->execute();
$mensajes = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Consulta para gráfico (mensajes por mes)
$sqlGrafico = "SELECT 
                DATE_FORMAT(fecha_envio, '%Y-%m') as mes,
                DATE_FORMAT(fecha_envio, '%b %Y') as mes_formateado,
                COUNT(*) as total
               FROM mensajes_contacto
               WHERE YEAR(fecha_envio) = ?
               GROUP BY mes
               ORDER BY mes";

$stmtGrafico = $conn->prepare($sqlGrafico);
$stmtGrafico->bind_param("i", $filtroAnio);
$stmtGrafico->execute();
$datosGrafico = $stmtGrafico->get_result()->fetch_all(MYSQLI_ASSOC);

// Consulta para años disponibles
$sqlAnios = "SELECT DISTINCT YEAR(fecha_envio) as anio 
             FROM mensajes_contacto
             ORDER BY anio DESC";
$anios = $conn->query($sqlAnios)->fetch_all(MYSQLI_ASSOC);

// Preparar datos para Chart.js
$labels = array_column($datosGrafico, 'mes_formateado');
$data = array_column($datosGrafico, 'total');
$totalMensajes = array_sum($data);
?>