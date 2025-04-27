<?php
require_once "../config/conn.php"; // Asegúrate de que esta conexión esté configurada correctamente

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibe los datos del formulario
    $usuario = $_POST['usuario'];  // Cambié 'nombre' por 'usuario'
    $correo = $_POST['correo'];    // Cambié 'Correo' por 'correo' para mantener la consistencia en la nomenclatura
    $clave = $_POST['clave'];      // Cambié 'Clave' por 'clave' para la consistencia

    // Hashea la contraseña
    $clave_hash = password_hash($clave, PASSWORD_DEFAULT);  // 'Clave_hash' ya está definida en la tabla

    // Prepara la consulta SQL con sentencias preparadas
    $sql = "INSERT INTO usuarios (usuario, Correo, Clave) VALUES (?, ?, ?)";

    // Prepara la declaración
    if ($stmt = $conn->prepare($sql)) {
        // Vincula los parámetros
        $stmt->bind_param("sss", $usuario, $correo, $clave_hash);

        // Ejecuta la declaración
        if ($stmt->execute()) {
            echo "Nuevo registro creado exitosamente";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Cierra la declaración
        $stmt->close();
    } else {
        echo "Error al preparar la consulta: " . $conn->error;
    }

    // Cierra la conexión
    $conn->close();
}
?>
