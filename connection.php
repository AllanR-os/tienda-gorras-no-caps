<?php
// Configuración de la base de datos para Docker
// Las variables de entorno vienen de docker-compose.yml

$host = getenv('DB_HOST') ?: "db"; // "db" es el nombre del servicio MySQL en Docker
$user = getenv('DB_USER') ?: "root";
$password = getenv('DB_PASSWORD') ?: "rootpassword";
$database = getenv('DB_NAME') ?: "login_db";

$con = mysqli_connect($host, $user, $password, $database);

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
