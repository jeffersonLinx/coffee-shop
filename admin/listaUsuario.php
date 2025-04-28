<?php
session_start();
require_once "../config/conn.php"; // Asegúrate de que esta línea esté correcta y apunte al archivo de conexión

include("includes/header.php");

// Verificar si el usuario es admin
if ($_SESSION['rol'] != 'admin') {
    echo "<script>alert('Acceso denegado: No tienes permisos esta seccion.'); window.location.href = 'productos.php';</script>";
    exit();
}
?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Usuarios</h1>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-hover table-bordered" style="width: 100%;">
                <thead class="thead-dark">
                    <tr>
                        <th>id</th>
                        <th>Usuario</th>
                        <th>Nombre</th>
                        <!-- <th>Clave</th> -->
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = mysqli_query($conn, "SELECT * FROM usuarios ORDER BY id DESC");
                    while ($data = mysqli_fetch_assoc($query)) { ?>
                        <tr>
                            <td><?php echo $data['id']; ?></td>
                            <td><?php echo $data['usuario']; ?></td>
                            <td><?php echo $data['Correo']; ?></td>
                            <!-- <td><php echo $data['Clave']; ?></td> -->
                            <td><?php echo $data['rol']; ?></td>
                            <td>
                                <!-- Eliminar solo si el rol es admin -->
                                <!-- <php if ($_SESSION['rol'] == 'admin') { ?>
                                    <a href="../controllers/eliminar_usuario.php?id=<?php echo $data['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este usuario?')">Eliminar</a>
                                <php } ?> -->
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include("includes/footer.php"); ?>
