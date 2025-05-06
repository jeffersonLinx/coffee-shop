<?php
session_start();
if (!empty($_SESSION['active'])) {
    header('location: productos.php');
    exit;
}
$alert = '';
if (!empty($_SESSION['error_login'])) {
    $alert = $_SESSION['error_login'];
    unset($_SESSION['error_login']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Iniciar Sesión</title>

    <!-- Agregar los estilos de SB Admin y Bootstrap -->
    <link rel="stylesheet" type="text/css" href="../assets/css/sb-admin-2.min.css">
    <link rel="shortcut icon" href="../assets/img/favicon.ico" />
        <!-- Agregar el script de reCAPTCHA -->
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
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
                                <img class="img-thumbnail" src="../assets/imgEmpresa/index1.jpeg" alt="">
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Inicio de Sesión</h1>

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

                                    <!-- Formulario de inicio de sesión -->
                                    <form class="user" method="POST" action="../controllers/login.php" autocomplete="off">
        <div class="form-group">
            <input type="text" class="form-control form-control-user" id="usuario" name="usuario" placeholder="Usuario..." required>
        </div>
        <div class="form-group">
            <input type="password" class="form-control form-control-user" id="clave" name="clave" placeholder="Contraseña" required>
        </div>
        
        <!-- Agregar el widget de reCAPTCHA -->
        <div class="form-group d-flex justify-content-center">
            <div class="g-recaptcha" data-sitekey="6LdKFQUqAAAAAGeTPqnaH4lluclcjikR7PEuIzHx"></div>
        </div>
        
        <button type="submit" class="btn btn-primary btn-user btn-block">
            Iniciar sesión
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
