<?php
session_start();
require_once "../config/conn.php";

// Proteger esta página
if (empty($_SESSION['active'])) {
    header('Location: index.php');
    exit;
}

// Mensajes de alerta
$alert = '';
if (!empty($_SESSION['alert_mensaje'])) {
    $alert = $_SESSION['alert_mensaje'];
    unset($_SESSION['alert_mensaje']);
}

include("includes/header.php");

// Incluir la lógica del controlador
include_once("../controllers/controllerContacto.php");
?>


<?php if (!empty($alert)) : ?>
<script>
    Swal.fire({
        icon: '<?php echo strpos($alert, 'Error') !== false ? 'error' : 'success'; ?>',
        title: '<?php echo strpos($alert, 'Error') !== false ? '¡Error!' : '¡Éxito!'; ?>',
        text: '<?php echo $alert; ?>',
        showConfirmButton: true,
        confirmButtonText: 'Ok'
    });
</script>
<?php endif; ?>
    <!-- Contact Start -->
    <div class="container-fluid pt-5">
        <div class="container">
            <div class="section-title">
                <h4 class="text-primary text-uppercase" style="letter-spacing: 5px;"> Mensajes de Nuestros Contactados </h4>
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
        </div>
    </div>
    <!-- Contact End -->
<!-- Formulario de búsqueda -->
<form method="POST" class="mb-4 d-flex justify-content-start">
    <div class="mr-3">
        <label for="nombre_buscar"><strong>Buscar por nombre:</strong></label>
        <input type="text" class="form-control" name="nombre_buscar" id="nombre_buscar"
            value="<?php echo isset($_POST['nombre_buscar']) ? htmlspecialchars($_POST['nombre_buscar']) : ''; ?>"
            placeholder="Buscar nombre...">
    </div>
    <div class="ml-3">
        <button type="submit" class="btn btn-primary mt-4">Buscar</button>
    </div>
</form>


<!-- Mostrar mensajes en tarjetas -->
<div class="container">
    <div class="row">
        <?php while ($mensaje = mysqli_fetch_assoc($result)) : ?>
            <div class="col-md-3 mb-4">
                <div class="card bg-success text-light h-100">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($mensaje['nombre']); ?></h5>
                        <p class="card-text"><strong>Correo:</strong> <?php echo htmlspecialchars($mensaje['correo']); ?></p>
                        <p class="card-text"><strong>Asunto:</strong> <?php echo htmlspecialchars($mensaje['asunto']); ?></p>
                        <p class="card-text"><strong>Mensaje:</strong><br><?php echo nl2br(htmlspecialchars($mensaje['mensaje'])); ?></p>
                        <p class="card-text"><strong>Fecha:</strong> <?php echo htmlspecialchars($mensaje['fecha_envio']); ?></p>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<?php include("includes/footer.php"); ?>
