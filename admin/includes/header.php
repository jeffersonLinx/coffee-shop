<?php 
// session_start();
if (empty($_SESSION['id'])) {
    header('Location: ./');
} ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>MonteAromaCoffee</title>

    <!-- Custom fonts for this template-->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../assets/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-success sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->   
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="../index.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Monte Aroma Coffee<sup>linea</sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="../index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Menús</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link" href="categorias.php">
                    <i class="fas fa-tag"></i>
                    <span>Categorias</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="productos.php">
                    <i class="fas fa-list"></i>
                    <span>Productos</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="clientes.php">
                    <i class="fas fa-user"></i>
                    <span>Clientes</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="reserva.php">
                    <i class="fas fa-bookmark"></i>
                    <span>Reservas</span></a>   
            </li>    
            <li class="nav-item">
                <a class="nav-link" href="mensajes_contacto.php">
                    <i class="fas fa-address-book"></i>
                    <span> Contactos</span></a>   
            </li>
            <li class="nav-item">
                <a class="nav-link" href="listaUsuario.php">
                    <i class="fas fa-file-alt"></i>
                    <span>Mis usuarios</span></a>   
            </li>
            <li class="nav-item">
                <a class="nav-link" href="registraUsuario.php">
                    <i class="fas fa-user"></i>
                    <span>Registro usuario</span></a>
            </li>
            <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseReportes" aria-expanded="false" aria-controls="collapseReportes">
            <i class="fas fa-chart-pie"></i>
        <span>Reportes</span>
    </a>
    <div id="collapseReportes" class="collapse" aria-labelledby="headingReportes" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Tipos de Reporte:</h6>
            <a class="collapse-item" href="reportes.php">Reporte Reservas</a>
            <a class="collapse-item" href="reportesProductos.php">Reporte Productos</a>
            <a class="collapse-item" href="reporteClientes.php">Reportes Clientes</a>
            <a class="collapse-item" href="reporteContacto.php">Reporte Contacto</a>
            <a class="collapse-item" href="reporteProductoPorCategoria.php">Reporte Categoria</a>
            <a class="collapse-item" href="reporteUsuarioSistema.php">Reporte trabajadores</a>
        </div>
    </div>
</li>


            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>
                    <!-- Nav Item - User Information -->
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                <?php 
                                // Mostrar el nombre del usuario logueado
                                if(isset($_SESSION['usuario'])) {
                                    echo htmlspecialchars($_SESSION['usuario']); // Seguro contra XSS
                                } elseif(isset($_SESSION['usuario'])) {
                                    echo htmlspecialchars($_SESSION['usuario']); 
                                } else {
                                    echo 'Usuario';
                                }
                                ?>
                            </span>
                            <img class="img-profile rounded-circle" src="../assets/profe.jpg" alt="Imagen de perfil">
                        </a>
                        <!-- Dropdown - User Information -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="perfil.php"> <!-- Enlaza a una página de perfil -->
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                Perfil (<?php echo isset($_SESSION['rol']) ? ucfirst($_SESSION['rol']) : 'Usuario'; ?>)
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="../config/salir.php">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                Salir
                            </a>
                        </div>
                    </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">



<!-- Inicio para el header  -->
<!-- Bootstrap core JavaScript-->
<!-- jQuery -->
<!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> -->
<!-- Popper.js (para Bootstrap 4) -->
<!-- <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script> -->
<!-- Bootstrap 4 JS -->
<!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- fin para el header -->