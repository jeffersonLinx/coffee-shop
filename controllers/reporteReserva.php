<!-- reporteReserva.php -->
<?php
require_once "../config/conn.php";

// Consulta principal
$sql = "SELECT 
            r.nombre_cliente, 
            r.correo_cliente, 
            r.fecha_reserva, 
            r.hora_reserva, 
            r.estado,
            p.nombre AS producto
        FROM reservas r
        JOIN productos p ON r.id_producto = p.id
        ORDER BY r.fecha_reserva DESC";

$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
$reservas = $result->fetch_all(MYSQLI_ASSOC);

// Filtros
$estado = $_GET['estado'] ?? '';
$anio = $_GET['anio'] ?? date('Y');

// Consulta para gráfico de barras (ahora incluye estado en los resultados)
$sqlBarras = "
    SELECT 
        MONTH(fecha_reserva) AS mes,
        YEAR(fecha_reserva) AS anio,
        estado,
        COUNT(*) AS total
    FROM reservas
    WHERE YEAR(fecha_reserva) = ?
    " . ($estado !== '' ? "AND estado = ?" : "") . "
    GROUP BY mes, anio, estado
    ORDER BY mes ASC";

$stmtBarras = $conn->prepare($sqlBarras);
if ($estado !== '') {
    $stmtBarras->bind_param("is", $anio, $estado);
} else {
    $stmtBarras->bind_param("i", $anio);
}
$stmtBarras->execute();
$resBarras = $stmtBarras->get_result();
$resumenMensual = $resBarras->fetch_all(MYSQLI_ASSOC);

// Consulta para gráfico de torta
$sqlTorta = "
    SELECT 
        estado,
        COUNT(*) AS total
    FROM reservas
    GROUP BY estado";

$resTorta = $conn->query($sqlTorta);
$resumenPorEstado = $resTorta->fetch_all(MYSQLI_ASSOC);
?>