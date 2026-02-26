<?php

/**
 * Verifica si un usuario es administrador
 * @param mysqli $con La conexión a la base de datos
 * @return array|null Los datos del usuario admin o null si no es admin
 */
function check_admin($con)
{
    if (isset($_SESSION['user_id'])) {
        $id = $_SESSION['user_id'];
        $query = "SELECT * FROM users WHERE id = ? AND role = 'admin' LIMIT 1";
        
        $stmt = $con->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && mysqli_num_rows($result) > 0) {
            $user_data = mysqli_fetch_assoc($result);
            $stmt->close();
            return $user_data;
        }
        $stmt->close();
    }

    // Redirigir a login si no está autenticado como admin
    header("Location: login.php");
    die;
}

/**
 * Obtiene estadísticas del dashboard
 * @param mysqli $con La conexión a la base de datos
 * @return array Array con las estadísticas
 */
function getDashboardStats($con)
{
    $stats = [];
    
    // Total de productos
    $query = "SELECT COUNT(*) as total FROM products";
    $result = mysqli_query($con, $query);
    $stats['total_products'] = mysqli_fetch_assoc($result)['total'];
    
    // Total de usuarios
    $query = "SELECT COUNT(*) as total FROM users WHERE role = 'cliente'";
    $result = mysqli_query($con, $query);
    $stats['total_users'] = mysqli_fetch_assoc($result)['total'];
    
    // Total de items en carritos
    $query = "SELECT SUM(quantity) as total FROM cart";
    $result = mysqli_query($con, $query);
    $stats['total_cart_items'] = mysqli_fetch_assoc($result)['total'] ?? 0;
    
    // Productos por categoría
    $query = "SELECT category, COUNT(*) as count FROM products GROUP BY category";
    $result = mysqli_query($con, $query);
    $stats['products_by_category'] = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $stats['products_by_category'][$row['category']] = $row['count'];
    }
    
    return $stats;
}

/**
 * Obtiene todos los productos
 * @param mysqli $con La conexión a la base de datos
 * @return array Array de productos
 */
function getAllProducts($con)
{
    $query = "SELECT * FROM products ORDER BY id DESC";
    $result = mysqli_query($con, $query);
    $products = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $products[] = $row;
    }
    return $products;
}

/**
 * Obtiene un producto por ID
 * @param mysqli $con La conexión a la base de datos
 * @param int $id ID del producto
 * @return array|null Datos del producto o null
 */
function getProductById($con, $id)
{
    $query = "SELECT * FROM products WHERE id = ? LIMIT 1";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = mysqli_fetch_assoc($result);
    $stmt->close();
    return $product;
}

/**
 * Crea un nuevo producto
 * @param mysqli $con La conexión a la base de datos
 * @param array $data Datos del producto
 * @return bool True si se creó correctamente
 */
function createProduct($con, $data)
{
    $query = "INSERT INTO products (name, price, image, category) VALUES (?, ?, ?, ?)";
    $stmt = $con->prepare($query);
    $stmt->bind_param("sdss", $data['name'], $data['price'], $data['image'], $data['category']);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
}

/**
 * Actualiza un producto existente
 * @param mysqli $con La conexión a la base de datos
 * @param int $id ID del producto
 * @param array $data Datos del producto
 * @return bool True si se actualizó correctamente
 */
function updateProduct($con, $id, $data)
{
    $query = "UPDATE products SET name = ?, price = ?, image = ?, category = ? WHERE id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("sdssi", $data['name'], $data['price'], $data['image'], $data['category'], $id);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
}

/**
 * Elimina un producto
 * @param mysqli $con La conexión a la base de datos
 * @param int $id ID del producto
 * @return bool True si se eliminó correctamente
 */
function deleteProduct($con, $id)
{
    // Primero eliminar del carrito
    $query = "DELETE FROM cart WHERE product_id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    
    // Luego eliminar el producto
    $query = "DELETE FROM products WHERE id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $id);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
}

/**
 * Obtiene todos los usuarios
 * @param mysqli $con La conexión a la base de datos
 * @return array Array de usuarios
 */
function getAllUsers($con)
{
    $query = "SELECT id, user_name, email, role, date FROM users ORDER BY date DESC";
    $result = mysqli_query($con, $query);
    $users = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
    }
    return $users;
}

/**
 * Actualiza el rol de un usuario
 * @param mysqli $con La conexión a la base de datos
 * @param int $id ID del usuario
 * @param string $role Nuevo rol
 * @return bool True si se actualizó correctamente
 */
function updateUserRole($con, $id, $role)
{
    $query = "UPDATE users SET role = ? WHERE id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("si", $role, $id);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
}

/**
 * Elimina un usuario
 * @param mysqli $con La conexión a la base de datos
 * @param int $id ID del usuario
 * @return bool True si se eliminó correctamente
 */
function deleteUser($con, $id)
{
    // Primero eliminar su carrito
    $query = "DELETE FROM cart WHERE user_id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    
    // Luego eliminar el usuario
    $query = "DELETE FROM users WHERE id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $id);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
}

?>
