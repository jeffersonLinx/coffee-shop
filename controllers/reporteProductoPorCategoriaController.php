<?php
require_once "../config/conn.php";

// Consulta principal para el reporte
$sql = "SELECT 
            c.nombre_categoria, 
            COUNT(p.id) AS total_productos, 
            c.estado
        FROM categorias c
        LEFT JOIN productos p ON p.id_categoria = c.id
        GROUP BY c.id
        ORDER BY c.nombre_categoria";

// Manejo de filtros
$filtroEstado = $_GET['estado'] ?? '';

if ($filtroEstado !== '') {
    $sql = "SELECT 
                c.nombre_categoria, 
                COUNT(p.id) AS total_productos, 
                c.estado
            FROM categorias c
            LEFT JOIN productos p ON p.id_categoria = c.id
            WHERE c.estado = ?
            GROUP BY c.id
            ORDER BY c.nombre_categoria";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $filtroEstado);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query($sql);
}

$productosPorCategoria = $result->fetch_all(MYSQLI_ASSOC);

// Preparar datos para gráficos
$datosGraficoBarras = [];
$datosGraficoTorta = [];

foreach ($productosPorCategoria as $item) {
    $datosGraficoBarras[] = [
        'categoria' => $item['nombre_categoria'],
        'total' => $item['total_productos'],
        'estado' => $item['estado']
    ];
    
    $datosGraficoTorta[] = [
        'label' => $item['nombre_categoria'],
        'value' => $item['total_productos'],
        'estado' => $item['estado']
    ];
}
?>