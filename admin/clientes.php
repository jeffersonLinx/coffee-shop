<!-- Alertas  -->
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
?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Clientes</h1>
</div>

<?php if (!empty($alert)) : ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-hover table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Fecha de Registro</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = mysqli_query($conn, "SELECT * FROM clientes ORDER BY id DESC");
                    $contador = 1;
                    while ($cliente = mysqli_fetch_assoc($query)) {
                    ?>
                        <tr>
                            <td><?php echo $contador++; ?></td>
                            <td><?php echo htmlspecialchars($cliente['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($cliente['correo']); ?></td>
                            <td><?php echo htmlspecialchars($cliente['fecha_registro']); ?></td>
                            <td>
                            <button 
                                class="btn btn-sm btn-primary editarCliente" 
                                data-toggle="modal" 
                                data-target="#modalEditarCliente"
                                data-id="<?php echo $cliente['id']; ?>"
                                data-nombre="<?php echo htmlspecialchars($cliente['nombre']); ?>"
                                data-correo="<?php echo htmlspecialchars($cliente['correo']); ?>"
                            >
                                Editar
                            </button>
                        </td>
                        </tr>
                    <?php } ?>
                    
                </tbody>
            </table>
        </div>
    </div>
</div>

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


