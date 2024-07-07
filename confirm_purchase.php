<?php
session_start();
include 'conexion.php';

if (!isset($_SESSION['user_id']) || empty($_SESSION['cart'])) {
    header("Location: login.php");
    exit;
}

$userId = $_SESSION['user_id'];
$cart = $_SESSION['cart'];
$total = 0;

// Calcular el total de la venta
foreach ($cart as $productId => $quantity) {
    $sql = "SELECT precio FROM producto WHERE id = $productId";
    $result = $conn->query($sql);
    if ($row = $result->fetch_assoc()) {
        $total += $row['precio'] * $quantity;
    }
}

$sql = "INSERT INTO Venta (fechaVenta, totalVenta, id_usuario) VALUES (NOW(), $total, $userId)";
if ($conn->query($sql) === TRUE) {
    $ventaId = $conn->insert_id;

    foreach ($cart as $productId => $quantity) {
        $sql = "SELECT precio FROM producto WHERE id = $productId";
        $result = $conn->query($sql);
        if ($row = $result->fetch_assoc()) {
            $precioUnitario = $row['precio'];
            $sql = "INSERT INTO DetalleVenta (id_producto, id_venta, precioUnitario, cantidad) VALUES ($productId, $ventaId, $precioUnitario, $quantity)";
            $conn->query($sql);
        }
    }

    unset($_SESSION['cart']);
    header("Location: index.php");
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>