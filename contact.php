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
    <?php include 'body/header.php'; ?>
    <!-- Navbar End -->


    <!-- Page Header Start -->
    <div class="container-fluid page-header mb-5 position-relative overlay-bottom">
        <div class="d-flex flex-column align-items-center justify-content-center pt-0 pt-lg-5" style="min-height: 400px">
            <h1 class="display-4 mb-3 mt-0 mt-lg-5 text-white text-uppercase">Contactanos</h1>
            <div class="d-inline-flex mb-lg-5">
                <p class="m-0 text-white"><a class="text-white" href="">Inicio</a></p>
                <p class="m-0 text-white px-2">/</p>
                <p class="m-0 text-white">Contactanos</p>
            </div>
        </div>
    </div>
    <!-- Page Header End -->


    <!-- Contact Start -->
    <div class="container-fluid pt-5">
        <div class="container">
            <div class="section-title">
                <h4 class="text-primary text-uppercase" style="letter-spacing: 5px;">Contactanos</h4>
                <h1 class="display-4">No dudes en contactar</h1>
            </div>
            <div class="row px-3 pb-2">
                <div class="col-sm-4 text-center mb-3">
                    <i class="fa fa-2x fa-map-marker-alt mb-3 text-primary"></i>
                    <h4 class="font-weight-bold">Direccion</h4>
                    <p>Calle 4°N 316, Zona Eqipetrol , Santan Cruz, Bolivia </p>
                </div>
                <div class="col-sm-4 text-center mb-3">
                    <i class="fa fa-2x fa-phone-alt mb-3 text-primary"></i>
                    <h4 class="font-weight-bold">Nuestro Telf.</h4>
                    <p>+591 77654321</p>
                </div>
                <div class="col-sm-4 text-center mb-3">
                    <i class="far fa-2x fa-envelope mb-3 text-primary"></i>
                    <h4 class="font-weight-bold">Email</h4>
                    <p>contacto@montearomacoffee.bo</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 pb-5">
                    <iframe style="width: 100%; height: 443px;"  
                    src="https://www.google.com/maps?q=-17.76015055334364,-63.19982116105084&z=15&output=embed" 
                    width="600" 
                    height="450" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
                
                </div>
                <div class="col-md-6 pb-5">
                    <div class="contact-form">
                        <div id="success"></div>
                        <form name="sentMessage" id="contactForm" method="POST" action="#" novalidate="novalidate">

                        <div class="control-group">
                            <input type="text" name="name" class="form-control bg-transparent p-4" id="name" placeholder="Tu nombre"
                                required="required" data-validation-required-message="Por favor ingresa tu nombre" />
                            <p class="help-block text-danger"></p>
                        </div>

                        <div class="control-group">
                            <input type="email" name="email" class="form-control bg-transparent p-4" id="email" placeholder="Tu correo"
                                required="required" data-validation-required-message="Por favor ingresa tu correo" />
                            <p class="help-block text-danger"></p>
                        </div>

                        <div class="control-group">
                            <input type="text" name="subject" class="form-control bg-transparent p-4" id="subject" placeholder="Asunto"
                                required="required" data-validation-required-message="Por favor ingresa un asunto" />
                            <p class="help-block text-danger"></p>
                        </div>

                        <div class="control-group">
                            <textarea name="message" class="form-control bg-transparent py-3 px-4" rows="5" id="message" placeholder="Mensaje"
                                required="required" data-validation-required-message="Por favor ingresa tu mensaje"></textarea>
                            <p class="help-block text-danger"></p>
                        </div>

                        <div>
                            <button class="btn btn-primary font-weight-bold py-3 px-5" type="submit" id="sendMessageButton">
                                Enviar Mensaje
                            </button>
                        </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact End -->


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