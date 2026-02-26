<?php
session_start();
include("connection.php");
include("functions.php");

$error_message = "";

// En signup.php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $user_name = sanitizeInput($_POST['user_name']);
    $password = sanitizeInput($_POST['password']);
    $confirm_password = sanitizeInput($_POST['confirm_password']);
    $email = sanitizeInput($_POST['email']);

    if (!empty($user_name) && !empty($password) && !empty($confirm_password) && !empty($email) && !is_numeric($user_name)) {
        if ($password !== $confirm_password) {
            $error_message = "Las contraseñas no coinciden.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error_message = "Por favor, ingresa un correo electrónico válido.";
        } else {
            $query = "SELECT * FROM users WHERE user_name = ? OR email = ? LIMIT 1";
            $stmt = mysqli_prepare($con, $query);
            mysqli_stmt_bind_param($stmt, "ss", $user_name, $email);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) > 0) {
                $error_message = "El nombre de usuario o correo electrónico ya está en uso.";
            } else {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $query = "INSERT INTO users (user_name, email, password) VALUES (?, ?, ?)";
                $stmt = mysqli_prepare($con, $query);
                mysqli_stmt_bind_param($stmt, "sss", $user_name, $email, $hashed_password);
                
                if (mysqli_stmt_execute($stmt)) {
                    header("Location: login.php");
                    die;
                } else {
                    $error_message = "Error al registrar el usuario. Inténtalo de nuevo.";
                }
            }
            mysqli_stmt_close($stmt);
        }
    } else {
        $error_message = "Por favor, completa todos los campos con información válida.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Registrarse</title>
    <link rel="stylesheet" type="text/css" href="login_singup.css">
        <link rel="icon" type="image/png" href="https://img.freepik.com/vector-premium/plantilla-maquillaje-vectorial-gorra-beisbol-blanca-realista-3d-aislada-sobre-fondo-blanco_272204-23479.jpg?semt=ais_hybrid">

</head>
<body>
    <div class="container">
        <div class="form_area">
            <p class="title">REGISTRARSE</p>
            <?php if (!empty($error_message)): ?>
                <div class="error-message">
                    <p><?php echo $error_message; ?></p>
                </div>
            <?php endif; ?>
            <form method="post" action="signup.php">
                <div class="form_group">
                    <label class="sub_title" for="user_name">Nombre de Usuario</label>
                    <input placeholder="Ingresa tu nombre de usuario" class="form_style" type="text" name="user_name" id="user_name" required>
                </div>
                <div class="form_group">
                    <label class="sub_title" for="email">Correo Electrónico</label>
                    <input placeholder="Ingresa tu correo electrónico" class="form_style" type="email" name="email" id="email" required>
                </div>
                <div class="form_group">
                    <label class="sub_title" for="password">Contraseña</label>
                    <input placeholder="Ingresa tu contraseña" class="form_style" type="password" name="password" id="password" required>
                </div>
                <div class="form_group">
                    <label class="sub_title" for="confirm_password">Confirmar Contraseña</label>
                    <input placeholder="Confirma tu contraseña" class="form_style" type="password" name="confirm_password" id="confirm_password" required>
                </div>
                <div>
                    <button class="btn" type="submit">REGISTRARSE</button>
                    <p>¿Ya tienes una cuenta? <a class="link" href="login.php">Inicia sesión aquí</a></p>
                </div>
            </form>
        </div>
    </div>
</body>
</html>