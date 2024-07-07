<?php
include 'conexion.php';
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 1) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin interfaz</title>
    <link rel="stylesheet" href="EXT/BOOTSTRAP/css/bootstrap.min.css">
</head>

<body>
    <h1>Bienvido admin</h1>
    <h3>Elija una de estas opciones:</h3>
    <ul>
        <li>
            <a href="admin_productos.php">Gestionar Productos</a>
        </li>
        <li>
            <a href="admin_categoria.php">Gestionar Categorias</a>
        </li>
    </ul>
</body>

</html>