<!-- registro.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Registro</title>
</head>
<body>
    <h2>Registro de Usuario</h2>
    <form action="../controllers/registrar.php" method="POST">
        <label for="usuario">Nombre de usuario:</label>
        <input type="text" id="usuario" name="usuario" required><br><br>

        <label for="correo">Correo:</label>
        <input type="email" id="correo" name="correo" required><br><br>

        <label for="clave">Contraseña:</label>
        <input type="password" id="clave" name="clave" required><br><br>

        <input type="submit" value="Registrar">
    </form>
</body>
</html>
