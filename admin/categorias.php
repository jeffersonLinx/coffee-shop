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

// Registrar nueva categoría
if (!empty($_POST['nombre']) && empty($_POST['id'])) {
    $nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
    $query = mysqli_query($conn, "INSERT INTO categorias(nombre_categoria) VALUES ('$nombre')");
    if ($query) {
        $_SESSION['alert_categoria'] = 'Categoría registrada exitosamente';
    } else {
        $_SESSION['alert_categoria'] = 'Error al registrar categoría';
    }
    header('Location: categorias.php');
    exit;
}

// Mensajes de alerta
$alert = '';
if (!empty($_SESSION['alert_categoria'])) {
    $alert = $_SESSION['alert_categoria'];
    unset($_SESSION['alert_categoria']);
}

include("includes/header.php");
?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Categorías</h1>
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#categorias">
        <i class="fas fa-plus fa-sm text-white-50"></i> Nueva
    </a>
</div>

<?php if (!empty($alert)) : ?>
<script>
    <?php if (strpos($alert, 'Error') !== false) : ?>
        // Si el mensaje contiene "Error", se muestra la alerta de error
        Swal.fire({
            icon: 'error', // X roja para error
            title: '¡Error!',
            text: '<?php echo $alert; ?>', // Mensaje de error
            showConfirmButton: true,
            confirmButtonText: 'Ok'
        });
    <?php else : ?>
        // Si no es un error, se muestra la alerta de éxito
        Swal.fire({
            icon: 'success', // Check verde para éxito
            title: '¡Éxito!',
            text: '<?php echo $alert; ?>', // Mensaje de éxito
            showConfirmButton: true,
            confirmButtonText: 'Ok'
        });
    <?php endif; ?>
</script>
<?php endif; ?>


<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-hover table-bordered" style="width: 100%;">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre Categoría</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $query = mysqli_query($conn, "SELECT * FROM categorias ORDER BY id DESC");
                while ($data = mysqli_fetch_assoc($query)) { ?>
                    <tr>
                        <td><?php echo $data['id']; ?></td>
                        <td><?php echo $data['nombre_categoria']; ?></td>
                        <td>
                            <?php if ($data['estado'] == 1) { ?>
                                <span class="badge badge-success">Activo</span>
                            <?php } else { ?>
                                <span class="badge badge-danger">Inactivo</span>
                            <?php } ?>
                        </td>
                        <td>
                        <button class="btn btn-warning btn-sm editarCategoria"
                            data-id="<?php echo $data['id']; ?>"
                            data-nombre="<?php echo htmlspecialchars($data['nombre_categoria']); ?>"
                            data-toggle="modal" data-target="#modalEditar">
                            Editar
                        </button>


                            <?php if ($data['estado'] == 1) { ?>
                                <form method="post" action="../controllers/categoria_estado.php" class="d-inline">
                                    <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
                                    <input type="hidden" name="estado" value="0">
                                    <button class="btn btn-danger btn-sm" type="submit">Desactivar</button>
                                </form>
                            <?php } else { ?>
                                <form method="post" action="../controllers/categoria_estado.php" class="d-inline">
                                    <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
                                    <input type="hidden" name="estado" value="1">
                                    <button class="btn btn-success btn-sm" type="submit">Activar</button>
                                </form>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>

                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Nueva Categoría -->
<div id="categorias" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="nuevoCategoriaModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="" method="POST" autocomplete="off">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="title">Nueva Categoría</h5>
                    <button class="close" data-dismiss="modal" aria-label="Close"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id">
                    <div class="form-group">
                        <label for="nombre">Nombre Categoría</label>
                        <input id="nombre" class="form-control" type="text" name="nombre" placeholder="Ej: Café de Verano" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" type="submit">Registrar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Editar Categoría -->
<div id="modalEditar" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editarCategoriaModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="../controllers/categoria_edit.php" method="POST" autocomplete="off">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title">Editar Categoría</h5>
                    <button class="close" data-dismiss="modal" aria-label="Close"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="edit_id">
                    <div class="form-group">
                        <label for="edit_nombre">Nombre Categoría</label>
                        <input id="edit_nombre" class="form-control" type="text" name="nombre" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-warning" type="submit">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Script para llenar datos en Modal Editar -->
<?php include("includes/footer.php"); ?>
<script>
$(document).ready(function() {
    // Script para llenar datos en Modal Editar
    $('.editarCategoria').click(function() {
        var id = $(this).data('id');
        var nombre = $(this).data('nombre');
        $('#edit_id').val(id);
        $('#edit_nombre').val(nombre);
    });

    // Script para limpiar datos en Modal Nuevo
    $('[data-target="#categorias"]').click(function() {
        $('#nombre').val('');
    });
});
</script>




