<?php
session_start();
require_once "../config/conn.php";

if (!empty($_SESSION['active'])) {
    // Si ya está activo, redirige directamente a productos.php
    header('location: ../admin/productos.php');
    exit;
}

if (!empty($_POST)) {
    // Verifica si se ingresaron el usuario y la contraseña
    if (empty($_POST['usuario']) || empty($_POST['clave'])) {
        $_SESSION['error_login'] = 'Ingrese usuario y contraseña';
        header('Location: ../admin/index.php');
        exit;
    }

    $user = mysqli_real_escape_string($conn, $_POST['usuario']);
    $pass_input = mysqli_real_escape_string($conn, $_POST['clave']);

    // Consulta si existe el usuario en la base de datos
    $query = mysqli_query($conn, "SELECT * FROM usuarios WHERE usuario = '$user'");

    if ($query && mysqli_num_rows($query) > 0) {
        $dato = mysqli_fetch_array($query);

        // Depuración: Verifica los datos obtenidos
        // echo "<pre>"; var_dump($dato); echo "</pre>"; exit;

        // Verifica si la contraseña es correcta
        if (password_verify($pass_input, $dato['Clave'])) {  // Verifica con 'Clave' como está en tu tabla
            $_SESSION['active'] = true;
            $_SESSION['id'] = $dato['id'];
            $_SESSION['nombre'] = $dato['nombre'];
            $_SESSION['user'] = $dato['usuario'];

            // Redirige al área de productos
            header('Location: ../admin/productos.php');
            exit;
        } else {
            // Si la contraseña no es correcta
            $_SESSION['error_login'] = 'Contraseña incorrecta';
            session_destroy();
            header('Location: ../admin/index.php');
            exit;
        }
    } else {
        // Si el usuario no existe en la base de datos
        $_SESSION['error_login'] = 'Usuario no encontrado';
        session_destroy();
        header('Location: ../admin/index.php');
        exit;
    }
} else {
    // Si no se ha enviado el formulario
    header('Location: ../admin/index.php');
    exit;
}
