<!-- reporteProductoController.php ubicado en la carpeta controllers/reporteProductoController.php -->
<?php
require_once "../config/conn.php";

// Consulta para productos más reservados
$sql = "
    SELECT 
        p.id,
        p.nombre AS producto, 
        p.estado,
        COUNT(*) AS total_reservas
    FROM reservas r
    JOIN productos p ON r.id_producto = p.id
    GROUP BY p.id
    ORDER BY total_reservas DESC
";

$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
$productos = $result->fetch_all(MYSQLI_ASSOC);

// Separar datos para gráficos
$productosActivos = array_filter($productos, function($p) {
    return $p['estado'] == 1; // Solo productos activos
});

// Preparar datos para gráfico de barras (solo activos)
$datosBarras = [];
foreach ($productosActivos as $p) {
    $datosBarras[] = [
        'producto' => $p['producto'],
        'total_reservas' => $p['total_reservas']
    ];
}

// Preparar datos para gráfico de torta (todos los productos)
$datosTorta = [];
foreach ($productos as $p) {
    $datosTorta[] = [
        'producto' => $p['producto'],
        'total_reservas' => $p['total_reservas'],
        'estado' => $p['estado']
    ];
}
?>