<?php
session_start();

// Verificar si hay sesión iniciada
if (!isset($_SESSION['id_usuario'])) {
    header('Location: ../index.php'); // Redirecciona al login si no hay sesión
    exit();
}

// Verificar si el usuario es admin
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'admin') {
    echo "<script>alert('Acceso denegado: No tienes permisos para entrar aquí.'); window.location.href = '../index.php';</script>";
    exit();
}

$alert = '';
if (!empty($_SESSION['error_registro'])) {
    $alert = $_SESSION['error_registro'];
    unset($_SESSION['error_registro']);
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Registro</title>
    <!-- Agregar los estilos de SB Admin y Bootstrap -->
    <link rel="stylesheet" type="text/css" href="../assets/css/sb-admin-2.min.css">
    <link rel="shortcut icon" href="../assets/img/favicon.ico" />
</head>

<body class="bg-gradient-warning">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image">
                                <img class="img-thumbnail" src="../assets/imgEmpresa/worker.jpeg" alt="">
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Formulario de Registro usuarios</h1>

                                        <!-- Mostrar alertas si hay algún error -->
                                        <?php if (!empty($alert)) : ?>
                                            <div class="alert alert-danger text-center alert-dismissible fade show" role="alert">
                                                <?php echo $alert; ?>
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Formulario de registro -->
                                    <form class="user" method="POST" action="../controllers/registrar.php" autocomplete="off">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" id="usuario" name="usuario" placeholder="Nombre de usuario" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user" id="correo" name="correo" placeholder="Correo electrónico" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" id="clave" name="clave" placeholder="Contraseña" required>
                                        </div>
                                        <select name="rol" required class="form-control">
                                        <option value="admin">Administrador</option>
                                        <option value="usuario">Usuario</option>
                                        <option value="trabajador">Trabajador</option>
                                        </select>

                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Registrar
                                        </button>
                                        <button type="button" class="btn btn-secondary btn-user btn-block" onclick="window.history.back();">
                                            Volver
                                        </button>

                                        <hr>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="../assets/js/jquery-3.6.0.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../assets/js/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../assets/js/sb-admin-2.min.js"></script>

</body>

</html>
