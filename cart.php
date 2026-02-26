<?php
session_start();
include("connection.php");
include("functions.php");

// Verificar si el usuario está logueado
$user_data = check_login($con);

$user_id = $_SESSION['user_id'];

// Inicializar el carrito si no existe
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Función para sincronizar el carrito con la base de datos
function syncCartWithDatabase($con, $user_id, $cart) {
    // Eliminar todos los productos del carrito del usuario en la base de datos
    $query = "DELETE FROM cart WHERE user_id = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);

    // Insertar los productos actuales del carrito
    foreach ($cart as $product_id => $item) {
        $quantity = $item['quantity'];
        $query = "INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE quantity = ?";
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, "iiii", $user_id, $product_id, $quantity, $quantity);
        mysqli_stmt_execute($stmt);
    }
}

// Procesar acciones del carrito
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update_cart'])) {
        foreach ($_POST['quantity'] as $product_id => $quantity) {
            $quantity = (int)$quantity;
            if ($quantity <= 0) {
                unset($_SESSION['cart'][$product_id]);
            } else {
                $_SESSION['cart'][$product_id]['quantity'] = $quantity;
            }
        }
    } elseif (isset($_POST['remove_product'])) {
        $product_id = (int)$_POST['remove_product'];
        unset($_SESSION['cart'][$product_id]);
    } elseif (isset($_POST['clear_cart'])) {
        $_SESSION['cart'] = [];
    }

    // Sincronizar con la base de datos
    syncCartWithDatabase($con, $user_id, $_SESSION['cart']);

    header("Location: cart.php");
    exit;
}

// Calcular el total
$total = 0;
foreach ($_SESSION['cart'] as $item) {
    $total += $item['price'] * $item['quantity'];
}

// En pagina_principal.php
function saveCartToDatabase($con, $user_id, $cart) {
    // Primero eliminamos el carrito existente del usuario
    $query = "DELETE FROM cart WHERE user_id = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    
    // Luego insertamos los items actuales
    if (!empty($cart)) {
        $query = "INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($con, $query);
        
        foreach ($cart as $item) {
            mysqli_stmt_bind_param($stmt, "iii", $user_id, $item['id'], $item['quantity']);
            mysqli_stmt_execute($stmt);
        }
    }
}

// Llamar a esta función cada vez que se modifique el carrito
if (isset($_SESSION['user_id']) && isset($_SESSION['cart'])) {
    saveCartToDatabase($con, $_SESSION['user_id'], $_SESSION['cart']);
}
// In the section where you process cart updates, modify the quantity handling:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update_cart'])) {
        foreach ($_POST['quantity'] as $product_id => $quantity) {
            $quantity = (int)$quantity;
            
            // Limit quantity to a maximum of 50
            $quantity = min($quantity, 50);
            
            if ($quantity <= 0) {
                unset($_SESSION['cart'][$product_id]);
            } else {
                $_SESSION['cart'][$product_id]['quantity'] = $quantity;
            }
        }
    }
    // ... rest of the existing code
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Carrito de Compras - Desert Caps</title>
    <link rel="stylesheet" type="text/css" href="pag_principal_estilos.css">
        <link rel="icon" type="image/png" href="https://img.freepik.com/vector-premium/plantilla-maquillaje-vectorial-gorra-beisbol-blanca-realista-3d-aislada-sobre-fondo-blanco_272204-23479.jpg?semt=ais_hybrid">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        /* Estilos adicionales para la tabla del carrito */
        .cart-section {
            max-width: 1200px;
            margin: 40px auto;
            padding: 20px;
        }

        .cart-section h2 {
            font-size: 28px;
            color: #4a3c31;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .cart-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: #fffcf7;
            box-shadow: 0 4px 6px rgba(139, 109, 81, 0.1);
            border-radius: 10px;
        }

        .cart-table th,
        .cart-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .cart-table th {
            background-color: #f5f5f5;
            font-weight: bold;
            color: #4a3c31;
        }

        .cart-table td {
            color: #8b6d51;
        }

        .cart-table img {
            width: 50px;
            height: auto;
            vertical-align: middle;
        }

        .cart-table input[type="number"] {
            width: 60px;
            padding: 5px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: #fffcf7;
            color: #4a3c31;
        }

        .cart-total {
            text-align: right;
            font-size: 1.2em;
            margin: 20px 0;
            color: #4a3c31;
        }

        .cart-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .cart-actions .btn {
            padding: 10px 20px;
            background-color: #8b6d51;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }

        .cart-actions .btn:hover {
            background-color: #6d543f;
        }

        .cart-actions .btn-danger {
            background-color: #d9534f;
        }

        .cart-actions .btn-danger:hover {
            background-color: #c9302c;
        }

        .empty-cart {
            text-align: center;
            color: #8b6d51;
            font-size: 1.2em;
            margin: 40px 0;
        }

        /* Ajustes para el modo oscuro en el carrito */
        body.dark-mode .cart-section h2 {
            color: #f5f5f5;
        }

        body.dark-mode .cart-table {
            background-color: #2c2c2c;
            box-shadow: 0 4px 6px rgba(255, 255, 255, 0.1);
        }

        body.dark-mode .cart-table th {
            background-color: #3a3a3a;
            color: #f5f5f5;
        }

        body.dark-mode .cart-table td {
            color: #cccccc;
            border-bottom: 1px solid #444;
        }

        body.dark-mode .cart-table input[type="number"] {
            background-color: #3a3a3a;
            color: #f5f5f5;
            border: 1px solid #555;
        }

        body.dark-mode .cart-total {
            color: #f5f5f5;
        }

        body.dark-mode .empty-cart {
            color: #cccccc;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <header id="menu">

    <nav>
        <ul class='nav-bar'>
            <li class='logo'><a href='#'> desert cap</a>
            <input type="checkbox" id="toggle"> </li>
            <input type='checkbox' id='check' />
            <label for="check" class="open-menu"><i class="fas fa-bars"></i></label>
            <div class="menu">
                <li><a href="pagina_principal.php#hero" class="link">Inicio</a></li>
                <li class="dropdown">
                    <a href="#products" class="link">Productos</a>
                    <div class="dropdown-content">
                        <a href="golf.php#golf" class="link">Cowboy Golf</a>
                        <a href="golf.php#colab" class="link">Colaboraciones</a>
                        <a href="golf.php#edicion" class="link">Edición Especial</a>
                    </div>
                </li>
                <li><a href="cart.php" class="link">Tu Carrito (<span id="cart-count"><?php echo count($_SESSION['cart']); ?></span>)</a></li>
                <li><a href="logout.php" class="link">Cerrar Sesión</a></li>
                <li><button class="theme-toggle" id="theme-toggle" style="font-size: 27px;">🌘</button></li>
                <label for="check" class="close-menu"><i class="fas fa-times"></i></label>
            </div>
        </ul>
    </nav>
</header>

    <section class="cart-section">
        <h2>Tu Carrito de Compras</h2>
        <?php if (empty($_SESSION['cart'])): ?>
            <p class="empty-cart">Tu carrito está vacío. <a href="golf.php" class="link">Explora nuestros productos</a>.</p>
        <?php else: ?>
            <form method="post" action="cart.php">
                <table class="cart-table">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Imagen</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($_SESSION['cart'] as $product_id => $item): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($item['name']); ?></td>
                                <td><img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>"></td>
                                <td>$<?php echo number_format($item['price'], 2); ?></td>
                                <td>
                                    <input type="number" 
       name="quantity[<?php echo $product_id; ?>]" 
       value="<?php echo $item['quantity']; ?>" 
       min="1" 
       max="50">
                                </td>
                                <td>$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                                <td>
                                    <button type="submit" name="remove_product" value="<?php echo $product_id; ?>" class="btn btn-danger">Eliminar</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="cart-total">
                    <strong>Total: $<?php echo number_format($total, 2); ?></strong>
                </div>
                <div class="cart-actions">
                    <button type="submit" name="update_cart" class="btn">Actualizar Carrito</button>
                    <button type="submit" name="clear_cart" class="btn btn-danger">Vaciar Carrito</button>
                    <a href="https://www.paypal.com/signin?locale.x=es_MX" class="btn">Proceder al Pago</a>
                </div>
            </form>
        <?php endif; ?>
    </section>

    <footer>
        <p>© 2025 Desert Caps - Todos los derechos reservados</p>
    </footer>

    <script>
        // Script para el modo oscuro
        const toggleButton = document.getElementById('theme-toggle');
        const body = document.body;

        if (localStorage.getItem('theme') === 'dark') {
            body.classList.add('dark-mode');
            toggleButton.textContent = '☀️';
        }

        toggleButton.addEventListener('click', () => {
            body.classList.toggle('dark-mode');
            const isDarkMode = body.classList.contains('dark-mode');
            toggleButton.textContent = isDarkMode ? '☀️' : '🌘';
            localStorage.setItem('theme', isDarkMode ? 'dark' : 'light');
        });
    </script>
</body>
</html>