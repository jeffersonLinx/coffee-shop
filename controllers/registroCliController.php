<?php
include __DIR__ . '/../config/conn.php'; // Esto ya conecta usando $conn

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = trim($_POST['newsletterEmail']);

    if (!empty($correo) && filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        // Verificar si el correo ya está registrado
        $stmt = $conn->prepare("SELECT id FROM clientes WHERE correo = ?");
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 0) {
            // Insertar el correo
            $stmt = $conn->prepare("INSERT INTO clientes (correo) VALUES (?)");
            $stmt->bind_param("s", $correo);

            if ($stmt->execute()) {
                header("Location: ../index.php?registro=ok");
                exit();
            } else {
                header("Location: ../index.php?registro=error");
                exit();
            }
        } else {
            header("Location: ../index.php?registro=existente");
            exit();
        }

        $stmt->close();
        $conn->close();
    } else {
        header("Location: ../index.php?registro=invalid");
        exit();
    }
} else {
    header("Location: ../index.php");
    exit();
}
