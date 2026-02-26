<?php

/**
 * Sanitiza los datos de entrada para prevenir problemas de seguridad y formato.
 * @param string $data El dato a sanitizar.
 * @return string El dato sanitizado.
 */
function sanitizeInput($data)
{
    $data = trim($data); // Elimina espacios en blanco al inicio y final
    $data = stripslashes($data); // Elimina barras invertidas
    $data = htmlspecialchars($data); // Convierte caracteres especiales en entidades HTML
    return $data;
}

/**
 * Verifica si un usuario está logueado y retorna sus datos si es así.
 * @param mysqli $con La conexión a la base de datos.
 * @return array|null Los datos del usuario o null si no está logueado.
 */
function check_login($con)
{
    if (isset($_SESSION['user_id'])) {
        $id = $_SESSION['user_id'];
        $query = "SELECT * FROM users WHERE id = ? LIMIT 1"; // Usar placeholder para preparación

        // Preparar y ejecutar la consulta
        $stmt = $con->prepare($query);
        $stmt->bind_param("i", $id); // "i" para entero
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && mysqli_num_rows($result) > 0) {
            $user_data = mysqli_fetch_assoc($result);
            $stmt->close();
            return $user_data;
        }
        $stmt->close();
    }

    // Redirigir a login si no está autenticado
    header("Location: login.php");
    die;
}

/**
 * Genera un número aleatorio de la longitud especificada.
 * @param int $length Longitud deseada del número.
 * @return string Un número aleatorio.
 */
function random_num($length)
{
    $text = "";
    if ($length < 5) {
        $length = 5;
    }

    $len = rand(4, $length);

    for ($i = 0; $i < $len; $i++) {
        $text .= rand(0, 9);
    }

    return $text;
}

?>