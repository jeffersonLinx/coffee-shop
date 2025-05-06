<?php
session_start();
require_once "../config/conn.php";

if (!empty($_SESSION['active'])) {
    header('location: ../admin/productos.php');
    exit;
}

// Clave secreta de reCAPTCHA - ¡DEBES PROTEGER ESTA CLAVE EN PRODUCCIÓN!
define('RECAPTCHA_SECRET', '6LdKFQUqAAAAAF8g7vteVYh7C6DYkfWd_FSuVhO8');

if (!empty($_POST)) {
    // Verificar reCAPTCHA primero
    if (empty($_POST['g-recaptcha-response'])) {
        $_SESSION['error_login'] = 'Por favor, complete el reCAPTCHA';
        header('Location: ../admin/index.php');
        exit;
    }

    $captcha = $_POST['g-recaptcha-response'];
    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".RECAPTCHA_SECRET."&response=".$captcha);
    $responseKeys = json_decode($response, true);

    if(intval($responseKeys["success"]) !== 1) {
        $_SESSION['error_login'] = 'Error en la verificación reCAPTCHA';
        header('Location: ../admin/index.php');
        exit;
    }

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

        if (password_verify($pass_input, $dato['Clave'])) {
            $_SESSION['active'] = true;
            $_SESSION['id'] = $dato['id'];
            $_SESSION['nombre'] = $dato['nombre'];
            $_SESSION['user'] = $dato['usuario'];
            $_SESSION['rol'] = $dato['rol'];

            header('Location: ../admin/productos.php');
            exit;
        } else {
            $_SESSION['error_login'] = 'Contraseña incorrecta';
            session_destroy();
            header('Location: ../admin/index.php');
            exit;
        }
    } else {
        $_SESSION['error_login'] = 'Usuario no encontrado';
        session_destroy();
        header('Location: ../admin/index.php');
        exit;
    }
} else {
    header('Location: ../admin/index.php');
    exit;
}