<?php
require_once "../config/conn.php"; // Asegúrate de que esta conexión esté configurada correctamente

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibe los datos del formulario
    $usuario = $_POST['usuario'];  
    $correo = $_POST['correo'];    
    $clave = $_POST['clave'];      
    $rol = $_POST['rol'];  

    // Hashea la contraseña
    $clave_hash = password_hash($clave, PASSWORD_DEFAULT);  

    // Prepara la consulta SQL con sentencias preparadas
    $sql = "INSERT INTO usuarios (usuario, Correo, Clave, rol) VALUES (?, ?, ?, ?)";

    // Prepara la declaración
    if ($stmt = $conn->prepare($sql)) {
        // Vincula los parámetros
        $stmt->bind_param("ssss", $usuario, $correo, $clave_hash, $rol);

        // Ejecuta la declaración
        if ($stmt->execute()) {
            // Registro exitoso
            header("Location: ../admin/productos.php"); // Aquí te faltaba ".php"
            exit; 
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
