<?php
require_once "../config/conn.php";

// Consulta principal para el reporte
$sql = "SELECT 
            usuario, 
            correo, 
            rol
        FROM usuarios
        ORDER BY id";

// Manejo de filtros
$filtroRol = $_GET['rol'] ?? '';

if ($filtroRol !== '') {
    $sql = "SELECT 
                usuario, 
                correo, 
                rol
            FROM usuarios
            WHERE rol = ?
            ORDER BY id";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $filtroRol);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query($sql);
}

$usuarios = $result->fetch_all(MYSQLI_ASSOC);

// Consulta para resumen por roles
$sqlResumen = "SELECT 
                  rol, 
                  COUNT(*) as total
               FROM usuarios
               GROUP BY rol";

$resResumen = $conn->query($sqlResumen);
$resumenPorRol = $resResumen->fetch_all(MYSQLI_ASSOC);

// Preparar datos para gráficos
$datosGraficoBarras = [];
$datosGraficoTorta = [];

foreach ($resumenPorRol as $item) {
    $datosGraficoBarras[] = [
        'rol' => ucfirst($item['rol']),
        'total' => $item['total']
    ];
    
    $datosGraficoTorta[] = [
        'label' => ucfirst($item['rol']),
        'value' => $item['total']
    ];
}
?>