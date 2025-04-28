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

    <!-- Carousel Start -->
    <div class="container-fluid p-0 mb-5">
        <div id="blog-carousel" class="carousel slide overlay-bottom" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="w-100" src="img/carousel-1.jpg" alt="Image">
                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                        <h2 class="text-primary font-weight-medium m-0">Nosotros hemos estado sirviendo</h2>
                        <h1 class="display-1 text-white m-0">CAFE </h1>
                        <h2 class="text-white m-0">* Desde 2025 *</h2>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="w-100" src="img/carousel-2.jpg" alt="Image">
                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                        <h2 class="text-primary font-weight-medium m-0">Te ofrecemos una experiencia</h2>
                        <h1 class="display-1 text-white m-0">MONTE AROMA</h1>
                        <h2 class="text-white m-0">*  GRANO DE CAFE LOCAL *</h2>
                    </div>
                </div>
            </div>
            <a class="carousel-control-prev" href="#blog-carousel" data-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </a>
            <a class="carousel-control-next" href="#blog-carousel" data-slide="next">
                <span class="carousel-control-next-icon"></span>
            </a>
        </div>
    </div>
    <!-- Carousel End -->


    <!-- About Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="section-title">
                <h4 class="text-primary text-uppercase" style="letter-spacing: 5px;">Sobre Nosotros</h4>
                <h1 class="display-4">Un vistaso sobre nosotros</h1>
            </div>
            <div class="row">
                <div class="col-lg-4 py-0 py-lg-5">
                    <h1 class="mb-3">Nuestra Mision</h1>
                    <h5 class="mb-3">TITULO AQUI HINSERTAR SOBRE LA HISTORIA</h5>
                    <p> Promover el bienestar del consumidor, el respeto por el medio ambiente y el desarrollo local, mientras conectamos a las personas con los sabores naturales y auténticos de Bolivia. Nos guía la pasión por el café y el amor por la naturaleza, y nos esforzamos por ser líderes en la industria del café sostenible en la región.
                    </p>
                    <a href="" class="btn btn-secondary font-weight-bold py-2 px-4 mt-2">Leer mas</a>
                </div>
                <div class="col-lg-4 py-5 py-lg-0" style="min-height: 500px;">
                    <div class="position-relative h-100">
                        <img class="position-absolute w-100 h-100" src="img/about.png" style="object-fit: cover;">
                    </div>
                </div>
                <div class="col-lg-4 py-0 py-lg-5">
                    <h1 class="mb-3">Nuestra Vision</h1>
                    <p>Expandirnos hacia nuevos mercados de forma ética y consciente, llevando el auténtico aroma de Buena Vista a más personas, mientras mantenemos nuestra esencia natural y nuestras raíces bolivianas. Nos esforzamos por innovar y mejorar continuamente, colaborando con la comunidad local y otros actores en la industria para lograr un impacto positivo en la región
                    </p>
                    <h5 class="mb-3"><i class="fa fa-check text-primary mr-3"></i>  REFERENTE EN SANTA CRUZ </h5>
                    <h5 class="mb-3"><i class="fa fa-check text-primary mr-3"></i> SOSTENIBILIDAD </h5>
                    <h5 class="mb-3"><i class="fa fa-check text-primary mr-3"></i>EXCELETES PRODUCTOS</h5>
                    <a href="" class="btn btn-primary font-weight-bold py-2 px-4 mt-2">Leer mas</a>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->


    <!-- Service Start -->
    <div class="container-fluid pt-5">
        <div class="container">
            <div class="section-title">
                <h4 class="text-primary text-uppercase" style="letter-spacing: 5px;">Nuestros Servicios</h4>
                <h1 class="display-4">Granos Frescos y Organicos</h1>
            </div>
            <div class="row">
                <div class="col-lg-6 mb-5">
                    <div class="row align-items-center">
                        <div class="col-sm-5">
                            <img class="img-fluid mb-3 mb-sm-0" src="img/service-1.jpg" alt="">
                        </div>
                        <div class="col-sm-7">
                            <h4><i class="fa fa-truck service-icon"></i>Servicio Personalizado</h4>
                            <p class="m-0">Nuestro equipo está capacitado para guiar en la elección del café ideal, recomendando métodos de preparación y brindando una experiencia única que conecta con los sentidos.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-5">
                    <div class="row align-items-center">
                        <div class="col-sm-5">
                            <img class="img-fluid mb-3 mb-sm-0" src="img/service-2.jpg" alt="">
                        </div>
                        <div class="col-sm-7">
                            <h4><i class="fa fa-coffee service-icon"></i>Granos Frescos</h4>
                            <p class="m-0">Seleccionamos granos de café directamente de Buena Vista, una región reconocida por su riqueza natural. Cada lote se tuesta en pequeñas cantidades para garantizar frescura, aroma intenso y un sabor que resalta las notas auténticas del grano boliviano.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-5">
                    <div class="row align-items-center">
                        <div class="col-sm-5">
                            <img class="img-fluid mb-3 mb-sm-0" src="img/service-3.jpg" alt="">
                        </div>
                        <div class="col-sm-7">
                            <h4><i class="fa fa-award service-icon"></i>Cafe de Calidad</h4>
                            <p class="m-0">Nuestro café es 100% orgánico, libre de pesticidas y cultivado bajo prácticas sostenibles. Nos enfocamos en ofrecer un producto premium, con un perfil de sabor cuidadosamente trabajado, que satisface tanto al consumidor conocedor como al amante casual del café.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mb-5">
                    <div class="row align-items-center">
                        <div class="col-sm-5">
                            <img class="img-fluid mb-3 mb-sm-0" src="img/service-4.jpg" alt="">
                        </div>
                        <div class="col-sm-7">
                            <h4><i class="fa fa-table service-icon"></i>Rerserva Anticipadas</h4>
                            <p class="m-0"> Pensando en la comodidad de nuestros clientes, ofrecemos un sistema de reserva anticipada para pedidos personalizados, talleres de cata y experiencias de café. Esta opción permite asegurar disponibilidad y atención exclusiva en fechas programadas. </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Service End -->


    <!-- Offer Start -->
    <div class="offer container-fluid my-5 py-5 text-center position-relative overlay-top overlay-bottom">
        <div class="container py-5">
            <h1 class="display-3 text-primary mt-3">50% De Descuento</h1>
            <h1 class="text-white mb-3">Oferta Especial Los Domingos</h1>
            <h4 class="text-white font-weight-normal mb-4 pb-3">Solo para el domingo del 1 al 31 de Abril 2025</h4>
            <form class="form-inline justify-content-center mb-4">
                <div class="input-group">
                    <input type="text" class="form-control p-4" placeholder="Tu Email" style="height: 60px;">
                    <div class="input-group-append">
                        <button class="btn btn-primary font-weight-bold px-4" type="submit">Registrate</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Offer End -->


    <!-- Menu Start -->
    <div class="container-fluid pt-5">
        <div class="container">
            <div class="section-title">
                <h4 class="text-primary text-uppercase" style="letter-spacing: 5px;">Menu & Precios</h4>
                <h1 class="display-4">Precios Competitivos</h1>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <h1 class="mb-5">Productos de Inicio de temporada</h1>
                    <div class="row align-items-center mb-5">
                        <div class="col-4 col-sm-3">
                            <img class="w-100 rounded-circle mb-3 mb-sm-0" src="img/menu-1.jpg" alt="">
                            <h5 class="menu-price"  style="font-size: 16px;">Bs.XX</h5>
                        </div>
                        <div class="col-8 col-sm-9">
                            <h4>Café frío con Pachit + taza</h4>
                            <p class="m-0">Producto especial de temporada de verano</p>
                        </div>
                    </div>
                    <div class="row align-items-center mb-5">
                        <div class="col-4 col-sm-3">
                            <img class="w-100 rounded-circle mb-3 mb-sm-0" src="img/menu-2.jpg" alt="">
                            <h5 class="menu-price" style="font-size: 16px;">Bs.XX</h5>
                        </div>
                        <div class="col-8 col-sm-9">
                            <h4>Café + marcapáginas literario</h4>
                            <p class="m-0">Producto sugerido para el Dia del Libro</p>
                        </div>
                    </div>
                    <div class="row align-items-center mb-5">
                        <div class="col-4 col-sm-3">
                            <img class="w-100 rounded-circle mb-3 mb-sm-0" src="img/menu-3.jpg" alt="">
                            <h5 class="menu-price" style="font-size: 16px;">Bs.XX</h5>
                        </div>
                        <div class="col-8 col-sm-9">
                            <h4>Combo invernal + Playlist + receta</h4>
                            <p class="m-0">El mejor producto para el inviero de San Juan</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <h1 class="mb-5">Productos de media temporada y mas ...</h1>
                    <div class="row align-items-center mb-5">
                        <div class="col-4 col-sm-3">
                            <img class="w-100 rounded-circle mb-3 mb-sm-0" src="img/menu-1.jpg" alt="">
                            <h5 class="menu-price" style="font-size: 16px;">Bs.XX</h5>
                        </div>
                        <div class="col-8 col-sm-9">
                            <h4>Pack para dos + tarjeta</h4>
                            <p class="m-0">Producto especial para temporada de San Valentin</p>
                        </div>
                    </div>
                    <div class="row align-items-center mb-5">
                        <div class="col-4 col-sm-3">
                            <img class="w-100 rounded-circle mb-3 mb-sm-0" src="img/menu-2.jpg" alt="">
                            <h5 class="menu-price"style="font-size: 16px;" >Bs.XX</h5>
                        </div>
                        <div class="col-8 col-sm-9">
                            <h4>Pack regalo edición limitada</h4>
                            <p class="m-0"> Producto Especial para las fechas navideñas</p>
                        </div>
                    </div>
                    <div class="row align-items-center mb-5">
                        <div class="col-4 col-sm-3">
                            <img class="w-100 rounded-circle mb-3 mb-sm-0" src="img/menu-3.jpg" alt="">
                            <h5 class="menu-price" style="font-size: 16px;">Bs.XX</h5>
                        </div>
                        <div class="col-8 col-sm-9">
                            <h4>Cafe tostado </h4>
                            <p class="m-0">Cafe un producto sensillo pero util </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Menu End -->


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
                            <form class="mb-5">
                                <div class="form-group">
                                    <input type="text" class="form-control bg-transparent border-primary p-4" placeholder="Nombre"
                                        required="required" />
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control bg-transparent border-primary p-4" placeholder="Email"
                                        required="required" />
                                </div>
                                <div class="form-group">
                                    <div class="date" id="date" data-target-input="nearest">
                                        <input type="text" class="form-control bg-transparent border-primary p-4 datetimepicker-input" placeholder="Fecha" data-target="#date" data-toggle="datetimepicker"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="time" id="time" data-target-input="nearest">
                                        <input type="text" class="form-control bg-transparent border-primary p-4 datetimepicker-input" placeholder="Hora" data-target="#time" data-toggle="datetimepicker"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <select class="custom-select bg-transparent border-primary px-4" style="height: 49px;">
                                        <option selected> Café frío con Pachit + taza  </option>
                                        <option value="1">Pack para dos + tarjeta</option>
                                        <option value="2">  Café + marcapáginas literario </option>
                                        <option value="3"> Combo invernal + Playlist + receta </option>
                                        <option value="3"> Pack regalo edición limitada </option>
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


    <!-- Testimonial Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="section-title">
                <h4 class="text-primary text-uppercase" style="letter-spacing: 5px;">Reseñas</h4>
                <h1 class="display-4">Lo que disen nuestro clientes</h1>
            </div>
            <div class="owl-carousel testimonial-carousel">
                <div class="testimonial-item">
                    <div class="d-flex align-items-center mb-3">
                        <img class="img-fluid" src="img/testimonial-1.jpg" alt="">
                        <div class="ml-3">
                            <h4>Pamela</h4>
                            <i>Docente</i>
                        </div>
                    </div>
                    <p class="m-0">Me gusta el cafe con leche esta bueno</p>
                </div>
                <div class="testimonial-item">
                    <div class="d-flex align-items-center mb-3">
                        <img class="img-fluid" src="img/testimonial-2.jpg" alt="">
                        <div class="ml-3">
                            <h4>Henry</h4>
                            <i>Deportista</i>
                        </div>
                    </div>
                    <p class="m-0">Cafe de madrugada esta bueno</p>
                </div>
                <div class="testimonial-item">
                    <div class="d-flex align-items-center mb-3">
                        <img class="img-fluid" src="img/testimonial-3.jpg" alt="">
                        <div class="ml-3">
                            <h4>Camila</h4>
                            <i>Estudiante </i>
                        </div>
                    </div>
                    <p class="m-0">Cafe antes de estudiar</p>
                </div>
                <div class="testimonial-item">
                    <div class="d-flex align-items-center mb-3">
                        <img class="img-fluid" src="img/testimonial-4.jpg" alt="">
                        <div class="ml-3">
                            <h4>Jaime</h4>
                            <i>Piloto</i>
                        </div>
                    </div>
                    <p class="m-0">Esta bueno</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Testimonial End -->


          

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="fa fa-angle-double-up"></i></a>

<!-- // Inicio footer  -->
<?php include 'body/footer.php'; ?>
<!-- fin footer -->

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