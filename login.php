<?php
session_start();
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo_electronico = $_POST['correo_electronico'];
    $contraseña = $_POST['contraseña'];

    $sql = "SELECT * FROM Usuario WHERE correoElectronico = '$correo_electronico'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($contraseña, $row['contraseña'])) {
            $_SESSION['user_id'] = $row['Id'];
            $_SESSION['user_name'] = $row['nombre'];
            $_SESSION['user_role'] = $row['rolid'];
            header("Location: index.php");
            exit;
        } else {
            $error = "Contraseña incorrecta.";
        }
    } else {
        $error = "No se encontró una cuenta con ese correo electrónico.";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="EXT/BOOTSTRAP/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="post" action="login.php">
            <div class="form-group">
                <label for="correo_electronico">Correo Electrónico:</label>
                <input type="email" class="form-control" id="correo_electronico" name="correo_electronico" required>
            </div>
            <div class="form-group">
                <label for="contraseña">Contraseña:</label>
                <input type="password" class="form-control" id="contraseña" name="contraseña" required>
            </div>
            <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
            <div class="form-group">
                <p>No tienes una cuenta?</p>
                <a href="register.php">Registrate</a>
            </div>
        </form>
    </div>

    <script src="EXT/jquery-3.7.1.min.js"></script>
    <script src="EXT/popper.min.js"></script>
    <script src="EXT/custom.js"></script>
    <script src="EXT/BOOTSTRAP/js/bootstrap.bundle.min.js"></script>
</body>
</html>