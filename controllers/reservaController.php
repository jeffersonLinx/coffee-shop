<?php
include __DIR__ . '/../config/conn.php';
// inclusión sea relativa al archivo actual, no al punto de entrada del script


$query = "SELECT id, nombre FROM productos WHERE estado = 1"; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
    $correo = mysqli_real_escape_string($conn, $_POST['correo']);
    $fecha = date("Y-m-d", strtotime($_POST['fecha'])); // Asegurar formato YYYY-MM-DD
    $hora = mysqli_real_escape_string($conn, $_POST['hora']);
    $id_producto = (int) $_POST['id_producto'];
    $estado = "pendiente";

    $sql = "INSERT INTO reservas (nombre_cliente, correo_cliente, fecha_reserva, hora_reserva, id_producto, estado) 
            VALUES ('$nombre', '$correo', '$fecha', '$hora', $id_producto, '$estado')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
            alert('Reserva enviada correctamente.');
            window.location.href = 'index.php';
        </script>";
    } else {
        echo "<script>
            alert('Error al registrar la reserva.');
            window.location.href = 'index.php';
        </script>";
    }
}
$resultado = mysqli_query($conn, $query);
?>
