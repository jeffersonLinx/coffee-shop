<?php
// Habilitar informes de errores para depuración
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Conexión a la base de datos
require_once "../config/conn.php";

// Verifica la conexión
if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Error de conexión: ' . $conn->connect_error]);
    exit;
}

// Recibir datos del formulario y limpiar espacios
$nombre = trim($_POST['name']);
$correo = trim($_POST['email']);
$asunto = trim($_POST['subject']);
$mensaje = trim($_POST['message']);

// Validar campos vacíos
if (empty($nombre) || empty($correo) || empty($asunto) || empty($mensaje)) {
    echo json_encode(['status' => 'error', 'message' => 'Por favor completa todos los campos.']);
    exit;
}

// Validar formato del correo
if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['status' => 'error', 'message' => 'Por favor ingresa un correo válido.']);
    exit;
}

try {
    // Preparar la consulta SQL
    $stmt = $conn->prepare("INSERT INTO mensajes_contacto (nombre, correo, asunto, mensaje) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nombre, $correo, $asunto, $mensaje);
    $stmt->execute();
    echo json_encode(['status' => 'success']);
} catch (mysqli_sql_exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'Error al enviar el mensaje: ' . $e->getMessage()]);
}

// Cerrar conexión
$stmt->close();
$conn->close();
?>
