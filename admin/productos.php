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
    <h1 class="h3 mb-0 text-gray-800">Productos</h1>
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#productos">
        <i class="fas fa-plus fa-sm text-white-50"></i> Nuevo
    </a>
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
                        <th>Imagen</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Precio Normal</th>
                        <th>Precio Rebajado</th>
                        <th>Cantidad</th>
                        <th>Categoría</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = mysqli_query($conn, "SELECT p.*, c.nombre_categoria, c.estado AS estado_categoria FROM productos p INNER JOIN categorias c ON c.id = p.id_categoria ORDER BY p.id DESC");
                    while ($data = mysqli_fetch_assoc($query)) {
                        // Determinar el estado del producto
                        $estado = $data['estado'] == 1 ? 'Activo' : 'Inactivo';
                        $estado_clase = $data['estado'] == 1 ? 'btn-success' : 'btn-danger';

                        // Verificar si la categoría está activa
                        $categoria_activa = $data['estado_categoria'] == 1;
                        $disabled = !$categoria_activa ? 'disabled' : '';
                    ?>
                    <tr>
                        <td><img src="../assets/img/<?php echo $data['imagen']; ?>" class="img-thumbnail" width="50"></td>
                        <td><?php echo $data['nombre']; ?></td>
                        <td><?php echo $data['descripcion']; ?></td>
                        <td><?php echo $data['precio_normal']; ?></td>
                        <td><?php echo $data['precio_rebajado']; ?></td>
                        <td><?php echo $data['cantidad']; ?></td>
                        <td><?php echo $data['nombre_categoria']; ?></td>
                        <td>
                            <?php if ($data['estado'] == 1) { ?>
                                <span class="badge badge-success">Activo</span>
                            <?php } else { ?>
                                <span class="badge badge-danger">Inactivo</span>
                            <?php } ?>
                        </td>
                        <td>
                            <!-- <span class="btn <php echo $estado_clase; ?> btn-sm"><php echo $estado; ?></span> -->
                            <button class="btn btn-warning btn-sm editarProducto"
                                data-id="<?php echo $data['id']; ?>"
                                data-nombre="<?php echo $data['nombre']; ?>"
                                data-descripcion="<?php echo $data['descripcion']; ?>"
                                data-precionormal="<?php echo $data['precio_normal']; ?>"
                                data-preciorebajado="<?php echo $data['precio_rebajado']; ?>"
                                data-cantidad="<?php echo $data['cantidad']; ?>"
                                data-categoria="<?php echo $data['id_categoria']; ?>"
                                data-toggle="modal" data-target="#modalEditar">
                                Editar
                            </button>
                            <form method="post" action="../controllers/producto_estado.php" class="d-inline">
                                <input type="hidden" name="id_producto" value="<?php echo $data['id']; ?>">
                                <button class="btn btn-info btn-sm" type="submit" <?php echo $disabled; ?>>Cambiar Estado</button>
                            </form>
                            <form method="post" action="eliminar.php?accion=pro&id=<?php echo $data['id']; ?>" class="d-inline eliminar">
                                <button class="btn btn-danger btn-sm" type="submit">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Nuevo Producto -->
<div id="productos" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="nuevoProductoModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="../controllers/producto_register.php" method="POST" enctype="multipart/form-data" autocomplete="off">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Nuevo Producto</h5>
                    <button class="close" data-dismiss="modal" aria-label="Close"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label>Nombre</label>
                            <input class="form-control" type="text" name="nombre" required>
                        </div>
                        <div class="col-md-6">
                            <label>Cantidad</label>
                            <input class="form-control" type="number" name="cantidad" required>
                        </div>
                        <div class="col-md-12">
                            <label>Descripción</label>
                            <textarea class="form-control" name="descripcion" rows="3" required></textarea>
                        </div>
                        <div class="col-md-6">
                            <label>Precio Normal</label>
                            <input class="form-control" type="text" name="p_normal" required>
                        </div>
                        <div class="col-md-6">
                            <label>Precio Rebajado</label>
                            <input class="form-control" type="text" name="p_rebajado" required>
                        </div>
                        <div class="col-md-6">
                            <label>Categoría</label>
                            <select class="form-control" name="categoria" required>
                                <?php
                                // Seleccionar solo las categorías activas
                                $categorias = mysqli_query($conn, "SELECT * FROM categorias WHERE estado = 1");
                                foreach ($categorias as $cat) {
                                    echo "<option value='{$cat['id']}'>{$cat['nombre_categoria']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Foto</label>
                            <input class="form-control" type="file" name="foto" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" type="submit">Registrar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Editar Producto -->
<div id="modalEditar" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editProductoModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="../controllers/producto_edit.php" method="POST" autocomplete="off">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title">Editar Producto</h5>
                    <button class="close" data-dismiss="modal" aria-label="Close"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="edit_id">
                    <div class="row">
                        <div class="col-md-6">
                            <label>Nombre</label>
                            <input class="form-control" type="text" name="nombre" id="edit_nombre" required>
                        </div>
                        <div class="col-md-6">
                            <label>Cantidad</label>
                            <input class="form-control" type="number" name="cantidad" id="edit_cantidad" required>
                        </div>
                        <div class="col-md-12">
                            <label>Descripción</label>
                            <textarea class="form-control" name="descripcion" id="edit_descripcion" rows="3" required></textarea>
                        </div>
                        <div class="col-md-6">
                            <label>Precio Normal</label>
                            <input class="form-control" type="text" name="p_normal" id="edit_p_normal" required>
                        </div>
                        <div class="col-md-6">
                            <label>Precio Rebajado</label>
                            <input class="form-control" type="text" name="p_rebajado" id="edit_p_rebajado" required>
                        </div>
                        <div class="col-md-6">
                            <label>Categoría</label>
                            <select class="form-control" name="categoria" required>
                                <?php
                                // Seleccionar solo las categorías activas
                                $categorias = mysqli_query($conn, "SELECT * FROM categorias WHERE estado = 1");
                                foreach ($categorias as $cat) {
                                    echo "<option value='{$cat['id']}'>{$cat['nombre_categoria']}</option>";
                                }
                                ?>
                            </select>
                        </div>
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
    $('.editarProducto').click(function() {
        var id = $(this).data('id');
        var nombre = $(this).data('nombre');
        var descripcion = $(this).data('descripcion');
        var precio_normal = $(this).data('precionormal');
        var precio_rebajado = $(this).data('preciorebajado');
        var cantidad = $(this).data('cantidad');
        var categoria = $(this).data('categoria');

        $('#edit_id').val(id);
        $('#edit_nombre').val(nombre);
        $('#edit_descripcion').val(descripcion);
        $('#edit_p_normal').val(precio_normal);
        $('#edit_p_rebajado').val(precio_rebajado);
        $('#edit_cantidad').val(cantidad);
        $('#edit_categoria').val(categoria);
    });
});
</script>

