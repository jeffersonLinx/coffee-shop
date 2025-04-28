<?php
include '../config/conn.php'; // tu conexión

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = isset($_POST['email']) ? trim($_POST['email']) : '';

    if (!empty($correo)) {
        // 1. Verificar si ya existe
        $check = $conn->prepare("SELECT id FROM clientes WHERE correo = ?");
        $check->bind_param("s", $correo);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            http_response_code(409); // Código de conflicto
            echo "El correo ya está registrado.";
        } else {
            // 2. Insertar nuevo
            $fecha = date('Y-m-d H:i:s');

            $stmt = $conn->prepare("INSERT INTO clientes (nombre, correo, fecha_registro) VALUES (NULL, ?, ?)");
            $stmt->bind_param("ss", $correo, $fecha);

            if ($stmt->execute()) {
                http_response_code(200);
                echo "Registro exitoso.";
            } else {
                http_response_code(500);
                echo "Error en la base de datos.";
            }

            $stmt->close();
        }

        $check->close();
        $conn->close();
    } else {
        http_response_code(400);
        echo "Correo inválido.";
    }
}
?>
