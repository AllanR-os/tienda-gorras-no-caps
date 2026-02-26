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
    $query = "DELETE FROM cart WHERE user_id = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);

    foreach ($cart as $product_id => $item) {
        $quantity = $item['quantity'];
        $query = "INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE quantity = ?";
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, "iiii", $user_id, $product_id, $quantity, $quantity);
        mysqli_stmt_execute($stmt);
    }
}

// Procesar acciones del carrito (para solicitudes POST y AJAX)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $response = ['success' => false, 'cart_count' => count($_SESSION['cart'])];

    if (isset($_POST['add_to_cart'])) {
        $product_id = (int)$_POST['product_id'];

        $query = "SELECT * FROM products WHERE id = ?";
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, "i", $product_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $product = mysqli_fetch_assoc($result);

        if ($product) {
            if (isset($_SESSION['cart'][$product_id])) {
                $_SESSION['cart'][$product_id]['quantity'] += 1;
            } else {
                $_SESSION['cart'][$product_id] = [
                    'id' => $product['id'],
                    'name' => $product['name'],
                    'price' => $product['price'],
                    'image' => $product['image'],
                    'quantity' => 1
                ];
            }

            syncCartWithDatabase($con, $user_id, $_SESSION['cart']);
            $response['success'] = true;
            $response['cart_count'] = count($_SESSION['cart']);
        }
    } elseif (isset($_POST['remove_from_cart'])) {
        $product_id = (int)$_POST['product_id'];
        if (isset($_SESSION['cart'][$product_id])) {
            unset($_SESSION['cart'][$product_id]);
            syncCartWithDatabase($con, $user_id, $_SESSION['cart']);
            $response['success'] = true;
            $response['cart_count'] = count($_SESSION['cart']);
        }
    }

    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }

    $redirect = "golf.php";
    if (isset($_POST['section'])) {
        $redirect .= "#" . $_POST['section'];
    }
    header("Location: $redirect");
    exit;
}

function saveCartToDatabase($con, $user_id, $cart) {
    $query = "DELETE FROM cart WHERE user_id = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    
    if (!empty($cart)) {
        $query = "INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($con, $query);
        
        foreach ($cart as $item) {
            mysqli_stmt_bind_param($stmt, "iii", $user_id, $item['id'], $item['quantity']);
            mysqli_stmt_execute($stmt);
        }
    }
}

if (isset($_SESSION['user_id']) && isset($_SESSION['cart'])) {
    saveCartToDatabase($con, $_SESSION['user_id'], $_SESSION['cart']);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Desert Caps - Tienda de Gorras</title>
    <link rel="stylesheet" href="pag_principal_estilos.css">
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

    <!-- GOLF -->
    <section class="herog" id="golf">
        <div class="hero-content">
            <h2>COWBOY GOLF</h2>
            <a href="#categorias" class="btn">Más colecciones</a>
        </div>
    </section>

    <section id="products" class="products">
        <h2>COWBOY GOLF</h2>
        <div class="product-grid">
            <?php
            $query = "SELECT * FROM products WHERE category = 'Cowboy Golf'";
            $result = mysqli_query($con, $query);
            while ($product = mysqli_fetch_assoc($result)):
            ?>
                <div class="product-card">
                    <div class="product-img">
                        <img style="width: 200px; height: auto;" src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                    </div>
                    <h3><?php echo $product['name']; ?></h3>
                    <p>$<?php echo number_format($product['price'], 2); ?></p>
                    <form class="cart-form" data-product-id="<?php echo $product['id']; ?>">
                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                        <input type="hidden" name="section" value="golf">
                        <button type="button" class="btn cart-btn <?php echo isset($_SESSION['cart'][$product['id']]) ? 'btn-agregado' : ''; ?>" 
                                data-action="<?php echo isset($_SESSION['cart'][$product['id']]) ? 'remove' : 'add'; ?>">
                            <?php echo isset($_SESSION['cart'][$product['id']]) ? 'Agregado' : 'Añadir al Carrito'; ?>
                        </button>
                    </form>
                </div>
            <?php endwhile; ?>
        </div>
    </section>

    <!-- COLABORACIONES -->
    <section class="heroC" id="colab">
        <div class="hero-content">
            <h2>COLABORACIONES</h2>
            <a href="#categorias" class="btn">Más colecciones</a>
        </div>
    </section>

    <section id="products" class="products">
        <h2>COLABORACIONES</h2>
        <div class="product-grid">
            <?php
            $query = "SELECT * FROM products WHERE category = 'Colaboraciones'";
            $result = mysqli_query($con, $query);
            while ($product = mysqli_fetch_assoc($result)):
            ?>
                <div class="product-card">
                    <div class="product-img">
                        <img style="width: 200px; height: auto;" src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                    </div>
                    <h3><?php echo $product['name']; ?></h3>
                    <p>$<?php echo number_format($product['price'], 2); ?></p>
                    <form class="cart-form" data-product-id="<?php echo $product['id']; ?>">
                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                        <input type="hidden" name="section" value="colab">
                        <button type="button" class="btn cart-btn <?php echo isset($_SESSION['cart'][$product['id']]) ? 'btn-agregado' : ''; ?>" 
                                data-action="<?php echo isset($_SESSION['cart'][$product['id']]) ? 'remove' : 'add'; ?>">
                            <?php echo isset($_SESSION['cart'][$product['id']]) ? 'Agregado' : 'Añadir al Carrito'; ?>
                        </button>
                    </form>
                </div>
            <?php endwhile; ?>
        </div>
    </section>

    <!-- EDICION ESPECIAL -->
    <section class="heroE" id="edicion">
        <div class="hero-content">
            <h2>EDICIÓN ESPECIAL</h2>
            <a href="#categorias" class="btn">Más colecciones</a>
        </div>
    </section>

    <section id="products" class="products">
        <h2>EDICIÓN ESPECIAL</h2>
        <div class="product-grid">
            <?php
            $query = "SELECT * FROM products WHERE category = 'Edicion Especial'";
            $result = mysqli_query($con, $query);
            while ($product = mysqli_fetch_assoc($result)):
            ?>
                <div class="product-card">
                    <div class="product-img">
                        <img style="width: 200px; height: auto;" src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                    </div>
                    <h3><?php echo $product['name']; ?></h3>
                    <p>$<?php echo number_format($product['price'], 2); ?></p>
                    <form class="cart-form" data-product-id="<?php echo $product['id']; ?>">
                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                        <input type="hidden" name="section" value="edicion">
                        <button type="button" class="btn cart-btn <?php echo isset($_SESSION['cart'][$product['id']]) ? 'btn-agregado' : ''; ?>" 
                                data-action="<?php echo isset($_SESSION['cart'][$product['id']]) ? 'remove' : 'add'; ?>">
                            <?php echo isset($_SESSION['cart'][$product['id']]) ? 'Agregado' : 'Añadir al Carrito'; ?>
                        </button>
                    </form>
                </div>
            <?php endwhile; ?>
        </div>
    </section>

    <!-- CATEGORIAS -->
    <section id="categorias" class="image-trio">
        <h2 style="text-align: center; font-size: 30px;">CATEGORÍAS</h2>
        <div class="trio-container">
            <div class="trio-item">
                <div class="trio-img" style="background-image: url('https://getyourhooey.com/cdn/shop/collections/8c0a34bc6d12f3abdedfa4c376458b2e_1600x.jpg?v=1740506220');"></div>
                <div class="trio-content">
                    <h2>COWBOY GOLF</h2>
                    <a href="golf.php#golf" class="btn">Ver Más</a>
                </div>
            </div>
            <div class="trio-item">
                <div class="trio-img" style="background-image: url('https://getyourhooey.com/cdn/shop/collections/544f3474c681cd6feca2972dfca48576_1600x.jpg?v=1693422005');"></div>
                <div class="trio-content">
                    <h2>COLABORACIONES</h2>
                    <a href="golf.php#colab" class="btn">Ver Más</a>
                </div>
            </div>
            <div class="trio-item">
                <div class="trio-img" style="background-image: url('https://getyourhooey.com/cdn/shop/collections/DSC01660_1_1200x.jpg?v=1740515504');"></div>
                <div class="trio-content">
                    <h2>EDICIÓN ESPECIAL</h2>
                    <a href="golf.php#edicion" class="btn">Ver Más</a>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <p>© 2025 Desert Caps - Todos los derechos reservados</p>
    </footer>

    <script>
        // Script para el carrito
        document.querySelectorAll('.cart-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('.cart-form');
                const productId = form.dataset.productId;
                const action = this.dataset.action;
                const cartCountElement = document.getElementById('cart-count');

                const formData = new FormData();
                formData.append('product_id', productId);
                formData.append(action === 'add' ? 'add_to_cart' : 'remove_from_cart', true);
                formData.append('section', form.querySelector('input[name="section"]').value);

                fetch('golf.php', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        if (action === 'add') {
                            this.textContent = 'Agregado';
                            this.classList.add('btn-agregado');
                            this.dataset.action = 'remove';
                        } else {
                            this.textContent = 'Añadir al Carrito';
                            this.classList.remove('btn-agregado');
                            this.dataset.action = 'add';
                        }
                        cartCountElement.textContent = data.cart_count;
                    } else {
                        alert('Hubo un error al procesar tu solicitud.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Hubo un error al procesar tu solicitud.');
                });
            });
        });

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