<?php 
session_start();
include("connection.php");

// Initialize error message variable
$error_message = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $user_name = $_POST['user_name'];
    $password = $_POST['password'];

    if (!empty($user_name) && !empty($password) && !is_numeric($user_name)) {
        // Usamos consulta preparada para prevenir SQL injection
        $query = "SELECT * FROM users WHERE user_name = ? LIMIT 1";
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, "s", $user_name);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            $user_data = mysqli_fetch_assoc($result);
            
            if (password_verify($password, $user_data['password'])) {
                $_SESSION['user_id'] = $user_data['id'];

                // Cargar el carrito desde la base de datos
                $user_id = $_SESSION['user_id'];
                $query = "SELECT c.product_id, c.quantity, p.name, p.price, p.image 
                         FROM cart c 
                         JOIN products p ON c.product_id = p.id 
                         WHERE c.user_id = ?";
                $stmt = mysqli_prepare($con, $query);
                mysqli_stmt_bind_param($stmt, "i", $user_id);
                mysqli_stmt_execute($stmt);
                $cart_result = mysqli_stmt_get_result($stmt);

                // Inicializar el carrito en la sesión
                $_SESSION['cart'] = [];
                while ($row = mysqli_fetch_assoc($cart_result)) {
                    $_SESSION['cart'][$row['product_id']] = [
                        'id' => $row['product_id'],
                        'name' => $row['name'],
                        'price' => $row['price'],
                        'image' => $row['image'],
                        'quantity' => $row['quantity']
                    ];
                }

                // Redirigir según el rol del usuario
                if (isset($user_data['role']) && $user_data['role'] == 'admin') {
                    header("Location: admin_panel.php");
                } else {
                    header("Location: pagina_principal.php");
                }
                die;
            } else {
                $error_message = "Contraseña incorrecta. Por favor, intenta de nuevo.";
            }
        } else {
            $error_message = "Usuario no encontrado. Por favor, verifica tu nombre de usuario.";
        }
        mysqli_stmt_close($stmt);
    } else {
        $error_message = "Por favor, ingresa un nombre de usuario y contraseña válidos.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" type="text/css" href="login_singup.css">
        <link rel="icon" type="image/png" href="https://img.freepik.com/vector-premium/plantilla-maquillaje-vectorial-gorra-beisbol-blanca-realista-3d-aislada-sobre-fondo-blanco_272204-23479.jpg?semt=ais_hybrid">

</head>
<body>
    <div class="container">
        <div class="form_area">
            <p class="title">INICIAR SESIÓN</p>
            <?php if (!empty($error_message)): ?>
                <div class="error-message">
                    <p><?php echo $error_message; ?></p>
                </div>
            <?php endif; ?>
            <form method="post" action="login.php">
                <div class="form_group">
                    <label class="sub_title" for="user_name">Nombre de Usuario</label>
                    <input placeholder="Ingresa tu nombre de usuario" class="form_style" type="text" name="user_name" id="user_name" required>
                </div>
                <div class="form_group">
                    <label class="sub_title" for="password">Contraseña</label>
                    <input placeholder="Ingresa tu contraseña" class="form_style" type="password" name="password" id="password" required>
                </div>
                <div class="form_group">
                    <input type="checkbox" name="remember_me" id="remember_me">
                    <label for="remember_me">Recordarme</label>
                </div>
                <div>
                    <button class="btn" type="submit">INICIAR SESIÓN</button>
                    <p>¿No tienes una cuenta? <a class="link" href="signup.php">Regístrate aquí</a></p>
                </div>
            </form>
        </div>
    </div>
</body>
</html>