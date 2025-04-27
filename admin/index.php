<?php
session_start();
if (!empty($_SESSION['active'])) {
    header('location: productos.php');
    exit;
}
$alert = '';
if (!empty($_SESSION['error_login'])) {
    $alert = $_SESSION['error_login'];
    unset($_SESSION['error_login']);
}
?>

<!-- HTML y form aquí -->

<?php if (!empty($alert)) : ?>
<div class="alert alert-danger text-center alert-dismissible fade show" role="alert">
    <?php echo $alert; ?>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<?php endif; ?>

<form class="user" method="POST" action="../controllers/login.php" autocomplete="off">
    <input type="text" class="form-control form-control-user" id="usuario" name="usuario" placeholder="Usuario...">
    <input type="password" class="form-control form-control-user" id="clave" name="clave" placeholder="Password">
    <button type="submit" class="btn btn-primary btn-user btn-block">Iniciar sesión</button>
</form>
