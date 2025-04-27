<?php
session_start();
require_once "../config/conn.php";

if (!empty($_SESSION['active'])) {
    header('location: ../admin/productos.php');
    exit;
}

if (!empty($_POST)) {
    if (empty($_POST['usuario']) || empty($_POST['clave'])) {
        $_SESSION['error_login'] = 'Ingrese usuario y contraseña';
        header('Location: index.php');
        exit;
    } else {
        $user = mysqli_real_escape_string($conn, $_POST['usuario']);
        $pass_input = mysqli_real_escape_string($conn, $_POST['clave']);

        // Buscamos el usuario
        $query = mysqli_query($conn, "SELECT * FROM usuarios WHERE usuario = '$user'");
        mysqli_close($conn);

        if ($query && mysqli_num_rows($query) > 0) {
            $dato = mysqli_fetch_array($query);

            // Ahora verificamos la contraseña encriptada
            if (password_verify($pass_input, $dato['clave'])) {
                $_SESSION['active'] = true;
                $_SESSION['id'] = $dato['id'];
                $_SESSION['nombre'] = $dato['nombre'];
                $_SESSION['user'] = $dato['usuario'];

                header('Location: ../admin/productos.php');
                exit;
            } else {
                $_SESSION['error_login'] = 'Contraseña o usuario incorrecto';
                session_destroy();
                header('Location: index.php');
                exit;
            }
        } else {
            $_SESSION['error_login'] = 'Contraseña o usuario incorrecto';
            session_destroy();
            header('Location: index.php');
            exit;
        }
    }
} else {
    header('Location: index.php');
    exit;
}
?>
