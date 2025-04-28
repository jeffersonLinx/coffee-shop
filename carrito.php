<?php require_once "config/conn.php"; 
require_once "config/config.php"; ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Carrito de Compras</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link href="assets/css/styles.css" rel="stylesheet" />
    <link href="assets/css/estilos.css" rel="stylesheet" />
    <style>
        body {
            background-color: #f7f4e3; /* Color suave de fondo tipo café con leche */
        }

        header {
            background-color: #3e2b47; /* Color profundo de café */
            color: #f1e6d1; /* Texto claro */
        }

        .btn-warning {
            background-color: #b89e64; /* Color café dorado */
            border: none;
        }

        .btn-warning:hover {
            background-color: #a88c57; /* Tono más oscuro al pasar el mouse */
        }

        table th, table td {
            text-align: center;
            vertical-align: middle;
        }

        footer {
            background-color: #3e2b47;
            color: #f1e6d1;
        }

        .btn-custom {
            background-color: #7a4b1d; /* Tono café cálido */
            color: white;
            border: none;
        }

        .btn-custom:hover {
            background-color: #9e6c40;
        }
    </style>
</head>

<body>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="assets/imgEmpresa/VHVV.jpeg">Monte Aroma Coffee</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </nav>
    </div>

    <header class="py-5">
        <div class="container text-center">
            <h1 class="display-4 fw-bolder">Carrito de Compras</h1>
            <p class="lead fw-normal mb-0">Tus productos agregados, listos para pagar.</p>
        </div>
    </header>

    <section class="py-5">
        <div class="container px-4 px-lg-5">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Producto</th>
                                    <th>Precio</th>
                                    <th>Cantidad</th>
                                    <th>Sub Total</th>
                                </tr>
                            </thead>
                            <tbody id="tblCarrito">
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-5 ms-auto">
                    <h4>Total a Pagar: <span id="total_pagar">0.00</span></h4>
                    <div class="d-grid gap-2">
                        <div id="paypal-button-container"></div>
                        <button class="btn btn-warning" type="button" id="btnVaciar">Vaciar Carrito</button>
                    </div>
                    <div class="d-grid gap-2 mt-3">
                        <button class="btn btn-custom" onclick="window.location.href='index.php'">Volver</button>
                        <button class="btn btn-custom" onclick="window.location.href='#'">Comprar</button> <!-- Dejar por implementar -->
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="https://www.paypal.com/sdk/js?client-id=<?php echo CLIENT_ID; ?>&locale=<?php echo LOCALE; ?>"></script>
    <script src="assets/js/scripts.js"></script>
    <script>
  // dentro  en carrito.php
  mostrarCarrito();

  function mostrarCarrito() {
    const cart = getCart(); // reutiliza la función de scripts.js
    if (cart.length > 0) {
      $.ajax({
        url: 'ajax.php',
        type: 'POST',
        data: { action: 'buscar', data: cart },
        success: function(response) {
          const res = JSON.parse(response);
          let html = '';
          res.datos.forEach(item => {
            html += `
              <tr>
                <td>${item.id}</td>
                <td>${item.nombre}</td>
                <td>${item.precio}</td>
                <td>1</td>
                <td>${item.precio}</td>
              </tr>`;
          });
          $('#tblCarrito').html(html);
          $('#total_pagar').text(res.total.toFixed(2));
          // Renderiza PayPal u otros...
        }
      });
    }
  }
</script>

</body>

</html>
