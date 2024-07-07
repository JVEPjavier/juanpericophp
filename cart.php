<?php
session_start();
include 'conexion.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$cart = $_SESSION['cart'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Carrito de Compras</title>
    <link rel="stylesheet" href="EXT/BOOTSTRAP/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Carrito de Compras</h2>
        <?php if (!empty($cart)): ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total = 0;
                    foreach ($cart as $productId => $quantity):
                        $sql = "SELECT * FROM producto WHERE id = $productId";
                        $result = $conn->query($sql);
                        if ($row = $result->fetch_assoc()):
                            $subtotal = $row['precio'] * $quantity;
                            $total += $subtotal;
                    ?>
                            <tr>
                                <td><?php echo $row['nombreProducto']; ?></td>
                                <td><?php echo $row['precio']; ?></td>
                                <td><?php echo $quantity; ?></td>
                                <td><?php echo $subtotal; ?></td>
                            </tr>
                    <?php
                        endif;
                    endforeach;
                    ?>
                    <tr>
                        <td colspan="3" align="right">Total</td>
                        <td><?php echo $total; ?></td>
                    </tr>
                </tbody>
            </table>
            <form action="confirm_purchase.php" method="post">
                <button type="submit" class="btn btn-success">Confirmar Compra</button>
            </form>
        <?php else: ?>
            <p>El carrito está vacío.</p>
        <?php endif; ?>
    </div>
</body>
</html>