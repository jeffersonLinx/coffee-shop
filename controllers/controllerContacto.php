<?php
require_once "../config/conn.php";

$nombreBuscar = isset($_POST['nombre_buscar']) ? trim($_POST['nombre_buscar']) : '';

$query = "SELECT * FROM mensajes_contacto";
if (!empty($nombreBuscar)) {
    $nombreBuscar = mysqli_real_escape_string($conn, $nombreBuscar);
    $query .= " WHERE nombre LIKE '%$nombreBuscar%'";
}
$query .= " ORDER BY id DESC";

$result = mysqli_query($conn, $query);
return $result;
