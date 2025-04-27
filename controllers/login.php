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
        $clave = md5(mysqli_real_escape_string($conn, $_POST['clave'])); // Usás md5 como pediste

        $query = mysqli_query($conn, "SELECT * FROM usuarios WHERE usuario = '$user' AND clave = '$clave'");
        mysqli_close($conn);

        $resultado = mysqli_num_rows($query);
        if ($resultado > 0) {
            $dato = mysqli_fetch_array($query);
            $_SESSION['active'] = true;
            $_SESSION['id'] = $dato['id'];
            $_SESSION['nombre'] = $dato['nombre'];
            $_SESSION['user'] = $dato['usuario'];

            header('Location: ../admin/productos.php');
            exit;
        } else {
            $_SESSION['error_login'] = 'Contraseña o usuario incorrecto';
            session_destroy();
            header('Location: ../admin/index.php');
            exit;
        }
    }
} else {
    header('Location: index.php');
    exit;
}
?>

