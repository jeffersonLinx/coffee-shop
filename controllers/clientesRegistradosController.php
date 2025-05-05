<?php
require_once "../config/conn.php";

// Obtener parámetros de filtro
$fechaInicio = $_GET['fecha_inicio'] ?? null;
$fechaFin = $_GET['fecha_fin'] ?? null;
$agrupacion = $_GET['agrupacion'] ?? 'mes'; // mes, trimestre, año

// Consulta base
$sqlClientes = "SELECT nombre, correo, fecha_registro FROM clientes WHERE 1=1";
$sqlEstadisticas = "SELECT COUNT(*) as total_clientes FROM clientes WHERE 1=1";

// Aplicar filtros de fecha
if ($fechaInicio) {
    $sqlClientes .= " AND DATE(fecha_registro) >= '$fechaInicio'";
    $sqlEstadisticas .= " AND DATE(fecha_registro) >= '$fechaInicio'";
}
if ($fechaFin) {
    $sqlClientes .= " AND DATE(fecha_registro) <= '$fechaFin'";
    $sqlEstadisticas .= " AND DATE(fecha_registro) <= '$fechaFin'";
}

// Ordenar
$sqlClientes .= " ORDER BY fecha_registro DESC";

// Paginación
$porPagina = 10;
$pagina = $_GET['pagina'] ?? 1;
$offset = ($pagina - 1) * $porPagina;
$sqlClientes .= " LIMIT $porPagina OFFSET $offset";

// Ejecutar consultas
$stmt = $conn->prepare($sqlClientes);
$stmt->execute();
$clientes = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

$stmtEst = $conn->prepare($sqlEstadisticas);
$stmtEst->execute();
$estadisticas = $stmtEst->get_result()->fetch_assoc();

// Consulta para gráfico (agrupado)
$sqlGrafico = "SELECT ";
switch ($agrupacion) {
    case 'año':
        $sqlGrafico .= "YEAR(fecha_registro) as periodo, 
                       CONCAT('Año ', YEAR(fecha_registro)) as periodo_label";
        break;
    case 'trimestre':
        $sqlGrafico .= "CONCAT(YEAR(fecha_registro), '-', QUARTER(fecha_registro)) as periodo, 
                       CONCAT('T', QUARTER(fecha_registro), ' ', YEAR(fecha_registro)) as periodo_label";
        break;
    default: // mes
        $sqlGrafico .= "DATE_FORMAT(fecha_registro, '%Y-%m') as periodo, 
                       DATE_FORMAT(fecha_registro, '%b %Y') as periodo_label";
}

$sqlGrafico .= ", COUNT(*) as cantidad 
                FROM clientes 
                WHERE 1=1";

if ($fechaInicio) {
    $sqlGrafico .= " AND DATE(fecha_registro) >= '$fechaInicio'";
}
if ($fechaFin) {
    $sqlGrafico .= " AND DATE(fecha_registro) <= '$fechaFin'";
}

$sqlGrafico .= " GROUP BY periodo 
                ORDER BY periodo";

$stmtGrafico = $conn->prepare($sqlGrafico);
$stmtGrafico->execute();
$datosGrafico = $stmtGrafico->get_result()->fetch_all(MYSQLI_ASSOC);

// Preparar datos para Chart.js
$labels = [];
$data = [];
foreach ($datosGrafico as $item) {
    $labels[] = $item['periodo_label'];
    $data[] = $item['cantidad'];
}
// Después de los filtros existentes
$busqueda = $_GET['busqueda'] ?? null;
if ($busqueda) {
    $sqlClientes .= " AND (nombre LIKE '%$busqueda%' OR correo LIKE '%$busqueda%')";
    $sqlEstadisticas .= " AND (nombre LIKE '%$busqueda%' OR correo LIKE '%$busqueda%')";
}
// Calcular total de páginas
$totalClientes = $estadisticas['total_clientes'];
$totalPaginas = ceil($totalClientes / $porPagina);

// Calcular promedio por periodo
$promedio = count($datosGrafico) > 0 ? round($totalClientes / count($datosGrafico), 2) : 0;
?>