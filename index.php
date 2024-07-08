<?php
include 'conexion.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

$idrol = $_SESSION['user_role'];

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="EXT/BOOTSTRAP/css/bootstrap.min.css">
    <title>Main</title>
    <style>
        .navbar-brand img {
            margin-left: 10px;
        }
        .form-inline {
            display: flex;
            flex-wrap: nowrap;
        }
        .form-inline .form-control {
            margin-right: 5px;
        }
        .ml-2 {
            margin-left: 10px;
        }
        .card {
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        .card-img-top {
            height: 200px;
            object-fit: cover;
        }
        .card-body {
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        .card-title {
            font-size: 1.25rem;
            margin-bottom: 10px;
        }
        .card-text {
            flex: 1;
        }
        .card-footer {
            display: flex;
            justify-content: space-between;
        }
    </style>
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">
            <img src="imagenes/logo1.png" width="210" height="80" alt="">
        </a>
        <form class="form-inline my-2 my-lg-0 mx-auto">
            <input class="form-control" type="search" placeholder="Buscar" aria-label="Buscar">
            <button class="btn btn-outline-success" type="submit">Buscar</button>
        </form>
        <a href="cart.php" class="btn btn-primary ml-2">Carrito</a>
        <?php if ($idrol == 1) : ?>
            <a href="admin.php" class="btn btn-primary ml-2">Admin</a>
        <?php endif; ?>
        <a href="logout.php" class="btn btn-secondary ml-2">Cerrar sesión</a>
    </nav>
    <div class="container mt-4">
        <h2 class="text-center">Bienvenido, <?php echo $_SESSION['user_name']; ?></h2>
        <div class="row">
            <?php
            $sql = "SELECT * FROM producto";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="col-md-4 mb-4">';
                    echo '<div class="card h-100">';
                    echo '<img class="card-img-top" src="imagenes/' . $row["imagen"] . '" alt="Card image cap">';
                    echo '<div class="card-body d-flex flex-column">';
                    echo '<h5 class="card-title">' . $row["nombreProducto"] . '</h5>';
                    echo '<p class="card-text">' . $row["descripcion"] . '</p>';
                    echo '<p class="card-text">Precio: $' . $row["precio"] . '</p>';
                    echo '</div>';
                    echo '<div class="card-footer">';
                    echo '<a href="producto.php?id=' . $row["id"] . '" class="btn btn-primary">Ver Producto</a>';
                    echo '<button class="btn btn-primary ml-2 add-to-cart" data-id="' . $row["id"] . '">Añadir al carrito</button>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo "<div class='col-12'><p class='text-center'>No hay productos disponibles</p></div>";
            }

            $conn->close();
            ?>
        </div>
    </div>

    <script src="EXT/jquery-3.7.1.min.js"></script>
    <script src="EXT/popper.min.js"></script>
    <script src="EXT/custom.js"></script>
    <script src="EXT/BOOTSTRAP/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.add-to-cart').click(function() {
                var productId = $(this).data('id');
                $.ajax({
                    url: 'add_to_cart.php',
                    method: 'POST',
                    data: {
                        id: productId
                    },
                    success: function(response) {
                        alert('Producto añadido al carrito');
                    }
                });
            });
        });
    </script>
</body>

</html>