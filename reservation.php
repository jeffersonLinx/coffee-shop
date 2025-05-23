<?php
include 'config/conn.php';
include 'controllers/reservaController.php';
include 'body/header.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>MonteAromaCofee</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free Website Template" name="keywords">
    <meta content="Free Website Template" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;400&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet"> 

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/style.min.css" rel="stylesheet">
</head>

<body>
    <!-- Navbar Start -->
    <!-- ?php  ?> -->
    <!-- Navbar End -->


    <!-- Page Header Start -->
    <div class="container-fluid page-header mb-5 position-relative overlay-bottom">
        <div class="d-flex flex-column align-items-center justify-content-center pt-0 pt-lg-5" style="min-height: 400px">
            <h1 class="display-4 mb-3 mt-0 mt-lg-5 text-white text-uppercase">Reservacion</h1>
            <div class="d-inline-flex mb-lg-5">
                <p class="m-0 text-white"><a class="text-white" href="">Inicio</a></p>
                <p class="m-0 text-white px-2">/</p>
                <p class="m-0 text-white">Reserva</p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->


    <!-- Reservation Start -->
    <div class="container-fluid my-5">
        <div class="container">
            <div class="reservation position-relative overlay-top overlay-bottom">
                <div class="row align-items-center">
                    <div class="col-lg-6 my-5 my-lg-0">
                        <div class="p-5">
                            <div class="mb-4">
                                <h1 class="display-3 text-primary">30% De menos en la primera compra</h1>
                                <h1 class="text-white">Para Reservas en Linea</h1>
                            </div>
                            <p class="text-white"> Reserva con un mes de adelanto tendra un descuento personalizado </p>
                            <ul class="list-inline text-white m-0">
                                <li class="py-2"><i class="fa fa-check text-primary mr-3"></i>Reserva antipadas</li>
                                <li class="py-2"><i class="fa fa-check text-primary mr-3"></i>1 mes de adelanto + descuento</li>
                                <li class="py-2"><i class="fa fa-check text-primary mr-3"></i> fechas especiales</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="text-center p-5" style="background: rgba(51, 33, 29, .8);">
                            <h1 class="text-white mb-4 mt-5">Reservas anticipadas</h1>
                            <form class="mb-5" method="POST" action="">
                            <!-- <form method="POST" action="controllers/reservaController.php"> -->
                                <div class="form-group">
                                <input type="text" name="nombre" class="form-control bg-transparent border-primary p-4" placeholder="Nombre" 
                                required />
                                </div>
                                <div class="form-group">
                                <input type="email" name="correo" class="form-control bg-transparent border-primary p-4" placeholder="Email" 
                                required />
                                </div>
                                <div class="form-group">
                                    <div class="date" id="date" data-target-input="nearest">
                                    <input type="text" name="fecha" class="form-control bg-transparent border-primary p-4 datetimepicker-input" placeholder="Para Fecha" data-target="#date" data-toggle="datetimepicker" required />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="time" id="time" data-target-input="nearest">
                                    <input type="text" name="hora" class="form-control bg-transparent border-primary p-4 datetimepicker-input" placeholder="Para Hora" data-target="#time" data-toggle="datetimepicker" required />
                                    </div>
                                </div>
                                <div class="form-group">
                                <select name="id_producto" class="custom-select bg-transparent border-primary px-4" style="height: 49px;" required>
                                        <option value="">Selecciona un producto</option>
                                        <?php while($row = mysqli_fetch_assoc($resultado)) { ?>
                                            <option value="<?php echo $row['id']; ?>">
                                                <?php echo htmlspecialchars($row['nombre']); ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>   
                                <div>
                                    <button class="btn btn-primary btn-block font-weight-bold py-3" type="submit">Reservas Ahora</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Reservation End -->


    <!-- Footer Start -->
    <?php include 'body/footer.php'; ?>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="fa fa-angle-double-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Contact Javascript File -->
    <script src="mail/jqBootstrapValidation.min.js"></script>
    <script src="mail/contact.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>