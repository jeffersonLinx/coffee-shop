<!-- Alertas --> 
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
if (!empty($_SESSION['alert_producto'])) {
    $alert = $_SESSION['alert_producto'];
    unset($_SESSION['alert_producto']);
}


include("includes/header.php");

// Obtener el filtro de estado, si está establecido
$estadoFiltro = isset($_POST['estado_filtro']) ? $_POST['estado_filtro'] : '';

// Obtener reservas con el filtro de estado
$query = "SELECT r.*, p.nombre AS nombre_producto FROM reservas r INNER JOIN productos p ON r.id_producto = p.id";
if ($estadoFiltro && in_array($estadoFiltro, ['pendiente', 'confirmada', 'cancelada'])) {
    $query .= " WHERE r.estado = '$estadoFiltro'";
}
$query .= " ORDER BY r.id DESC";
$result = mysqli_query($conn, $query);
?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Reservas hechas por Clientes</h1>
</div>

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

<!-- Filtro de estados -->
<form method="POST" class="mb-4 d-flex justify-content-end">
    <!-- Filtro de estado -->
    <div class="mr-3">
        <label for="estado_filtro"><strong>Filtrar por estado:</strong></label>
        <select class="form-control" name="estado_filtro" id="estado_filtro" onchange="this.form.submit()">
            <option value="">Todos</option>
            <option value="pendiente" <?php echo $estadoFiltro == 'pendiente' ? 'selected' : ''; ?>>Pendiente</option>
            <option value="confirmada" <?php echo $estadoFiltro == 'confirmada' ? 'selected' : ''; ?>>Confirmada</option>
            <option value="cancelada" <?php echo $estadoFiltro == 'cancelada' ? 'selected' : ''; ?>>Cancelada</option>
        </select>
    </div>

    <!-- Filtro por nombre -->
    <div class="ml-3">
        <label for="nombre_buscar"><strong>Buscar por nombre:</strong></label>
        <input type="text" class="form-control" name="nombre_buscar" id="nombre_buscar" value="<?php echo isset($_POST['nombre_buscar']) ? htmlspecialchars($_POST['nombre_buscar']) : ''; ?>" placeholder="Buscar nombre...">
    </div>

    <!-- Botón de búsqueda -->
    <div class="ml-3">
        <button type="submit" class="btn btn-primary">Buscar</button>
    </div>
</form>


<style>
    .badge-etiqueta {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 0.75rem;
        padding: 4px 10px;
        border-radius: 12px;
        color: white;
        z-index: 1;
    }

    .badge-pendiente {
        background-color: #ffc107; /* Amarillo */
        color: #212529;
    }

    .badge-confirmada {
        background-color: #28a745; /* Verde */
    }

    .badge-cancelada {
        background-color: #6c757d; /* Gris */
    }
</style>

<div class="container">
    <div class="row">
        <?php while ($reserva = mysqli_fetch_assoc($result)) {
            $estado = $reserva['estado'];
            $estadoTexto = ucfirst($estado);

            // Colores según estado
            switch ($estado) {
                case 'confirmada':
                    $cardClass = 'bg-success text-white';
                    $badgeClass = 'badge-etiqueta badge-confirmada';
                    break;
                case 'cancelada':
                    $cardClass = 'bg-secondary text-white';
                    $badgeClass = 'badge-etiqueta badge-cancelada';
                    break;
                default:
                    $cardClass = 'bg-warning text-dark';
                    $badgeClass = 'badge-etiqueta badge-pendiente';
                    break;
            }
        ?>
            <div class="col-md-3 mb-4">
                <div class="card position-relative <?php echo $cardClass; ?>">
                    <span class="<?php echo $badgeClass; ?>"><?php echo $estadoTexto; ?></span>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($reserva['nombre_cliente']); ?></h5>
                        <p class="card-text"><strong>Correo:</strong> <?php echo htmlspecialchars($reserva['correo_cliente']); ?></p>
                        <p class="card-text"><strong>Producto:</strong> <?php echo htmlspecialchars($reserva['nombre_producto']); ?></p>
                        <p class="card-text"><strong>Fecha:</strong> <?php echo htmlspecialchars($reserva['fecha_reserva']); ?></p>
                        <p class="card-text"><strong>Hora:</strong> <?php echo htmlspecialchars($reserva['hora_reserva']); ?></p>
                        <form action="../controllers/actualizar_estado_reserva.php" method="POST">
                            <input type="hidden" name="id_reserva" value="<?php echo $reserva['id']; ?>">
                            <div class="form-group">
                                <label for="estado-<?php echo $reserva['id']; ?>"><strong>Estado:</strong></label>
                                <select class="form-control" id="estado-<?php echo $reserva['id']; ?>" name="estado" onchange="this.form.submit()">
                                    <option value="pendiente" <?php if ($estado == 'pendiente') echo 'selected'; ?>>Pendiente</option>
                                    <option value="confirmada" <?php if ($estado == 'confirmada') echo 'selected'; ?>>Confirmada</option>
                                    <option value="cancelada" <?php if ($estado == 'cancelada') echo 'selected'; ?>>Cancelada</option>
                                </select>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<?php include("includes/footer.php"); ?>

<!-- Modal Editar Cliente -->
<div id="modalEditarCliente" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editClienteModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="../controllers/cliente_edit.php" method="POST" autocomplete="off">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title">Editar Cliente</h5>
                    <button class="close" data-dismiss="modal" aria-label="Close"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="edit_id">
                    <div class="form-group">
                        <label>Nombre</label>
                        <input class="form-control" type="text" name="nombre" id="edit_nombre" required>
                    </div>
                    <div class="form-group">
                        <label>Correo</label>
                        <input class="form-control" type="email" name="correo" id="edit_correo" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-warning" type="submit">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include("includes/footer.php"); ?>

<!-- Scripts para editar -->
<script>
$(document).ready(function() {
    $('.editarCliente').click(function() {
        var id = $(this).data('id');
        var nombre = $(this).data('nombre');
        var correo = $(this).data('correo');

        $('#edit_id').val(id);
        $('#edit_nombre').val(nombre);
        $('#edit_correo').val(correo);
    });
});
</script>
