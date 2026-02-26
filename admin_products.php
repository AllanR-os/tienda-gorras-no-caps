<?php
session_start();
include("connection.php");
include("functions.php");
include("admin_functions.php");

// Verificar si el usuario es administrador
$user_data = check_admin($con);

$message = "";
$message_type = "";

// Procesar acciones
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['create_product'])) {
        $data = [
            'name' => sanitizeInput($_POST['name']),
            'price' => floatval($_POST['price']),
            'image' => sanitizeInput($_POST['image']),
            'category' => sanitizeInput($_POST['category'])
        ];
        
        if (createProduct($con, $data)) {
            $message = "Producto creado exitosamente";
            $message_type = "success";
        } else {
            $message = "Error al crear el producto";
            $message_type = "error";
        }
    } elseif (isset($_POST['update_product'])) {
        $id = intval($_POST['id']);
        $data = [
            'name' => sanitizeInput($_POST['name']),
            'price' => floatval($_POST['price']),
            'image' => sanitizeInput($_POST['image']),
            'category' => sanitizeInput($_POST['category'])
        ];
        
        if (updateProduct($con, $id, $data)) {
            $message = "Producto actualizado exitosamente";
            $message_type = "success";
        } else {
            $message = "Error al actualizar el producto";
            $message_type = "error";
        }
    } elseif (isset($_POST['delete_product'])) {
        $id = intval($_POST['id']);
        if (deleteProduct($con, $id)) {
            $message = "Producto eliminado exitosamente";
            $message_type = "success";
        } else {
            $message = "Error al eliminar el producto";
            $message_type = "error";
        }
    }
}

// Obtener todos los productos
$products = getAllProducts($con);

// Obtener producto para editar si se solicita
$edit_product = null;
if (isset($_GET['edit'])) {
    $edit_product = getProductById($con, intval($_GET['edit']));
}

$show_form = isset($_GET['action']) && $_GET['action'] == 'new' || $edit_product;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Productos - Desert Caps</title>
    <link rel="icon" type="image/png" href="https://img.freepik.com/vector-premium/plantilla-maquillaje-vectorial-gorra-beisbol-blanca-realista-3d-aislada-sobre-fondo-blanco_272204-23479.jpg?semt=ais_hybrid">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="admin_styles.css">
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h2><i class="fas fa-hat-cowboy"></i> Desert Caps</h2>
            <p>Panel Admin</p>
        </div>
        <ul class="sidebar-menu">
            <li><a href="admin_panel.php"><i class="fas fa-dashboard"></i> Dashboard</a></li>
            <li><a href="admin_products.php" class="active"><i class="fas fa-box"></i> Productos</a></li>
            <li><a href="admin_users.php"><i class="fas fa-users"></i> Usuarios</a></li>
            <li><a href="pagina_principal.php" target="_blank"><i class="fas fa-store"></i> Ver Tienda</a></li>
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="topbar">
            <h1>Gestión de Productos</h1>
            <div class="user-info">
                <i class="fas fa-user-circle"></i>
                <span><?php echo htmlspecialchars($user_data['user_name']); ?></span>
            </div>
        </div>

        <div class="content">
            <?php if ($message): ?>
                <div class="alert alert-<?php echo $message_type; ?>">
                    <i class="fas fa-<?php echo $message_type == 'success' ? 'check-circle' : 'exclamation-circle'; ?>"></i>
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <!-- Formulario de Producto -->
            <?php if ($show_form): ?>
            <div class="card">
                <div class="card-header">
                    <h2>
                        <i class="fas fa-<?php echo $edit_product ? 'edit' : 'plus'; ?>"></i>
                        <?php echo $edit_product ? 'Editar Producto' : 'Nuevo Producto'; ?>
                    </h2>
                    <a href="admin_products.php" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                </div>
                <div class="card-body">
                    <form method="POST" class="product-form">
                        <?php if ($edit_product): ?>
                            <input type="hidden" name="id" value="<?php echo $edit_product['id']; ?>">
                        <?php endif; ?>

                        <div class="form-grid">
                            <div class="form-group">
                                <label for="name"><i class="fas fa-tag"></i> Nombre del Producto</label>
                                <input type="text" id="name" name="name" required 
                                       value="<?php echo $edit_product ? htmlspecialchars($edit_product['name']) : ''; ?>"
                                       placeholder="Ej: Gorra Cowboy Clásica">
                            </div>

                            <div class="form-group">
                                <label for="price"><i class="fas fa-dollar-sign"></i> Precio</label>
                                <input type="number" id="price" name="price" step="0.01" min="0" required 
                                       value="<?php echo $edit_product ? $edit_product['price'] : ''; ?>"
                                       placeholder="Ej: 29.99">
                            </div>

                            <div class="form-group full-width">
                                <label for="image"><i class="fas fa-image"></i> URL de Imagen</label>
                                <input type="url" id="image" name="image" required 
                                       value="<?php echo $edit_product ? htmlspecialchars($edit_product['image']) : ''; ?>"
                                       placeholder="https://ejemplo.com/imagen.jpg">
                            </div>

                            <div class="form-group full-width">
                                <label for="category"><i class="fas fa-layer-group"></i> Categoría</label>
                                <select id="category" name="category" required>
                                    <option value="">Selecciona una categoría</option>
                                    <option value="Cowboy Golf" <?php echo ($edit_product && $edit_product['category'] == 'Cowboy Golf') ? 'selected' : ''; ?>>Cowboy Golf</option>
                                    <option value="Colaboraciones" <?php echo ($edit_product && $edit_product['category'] == 'Colaboraciones') ? 'selected' : ''; ?>>Colaboraciones</option>
                                    <option value="Edición Especial" <?php echo ($edit_product && $edit_product['category'] == 'Edición Especial') ? 'selected' : ''; ?>>Edición Especial</option>
                                    <option value="Destacados" <?php echo ($edit_product && $edit_product['category'] == 'Destacados') ? 'selected' : ''; ?>>Destacados</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" name="<?php echo $edit_product ? 'update_product' : 'create_product'; ?>" class="btn btn-primary">
                                <i class="fas fa-save"></i> <?php echo $edit_product ? 'Actualizar' : 'Crear'; ?> Producto
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <?php endif; ?>

            <!-- Lista de Productos -->
            <div class="card">
                <div class="card-header">
                    <h2><i class="fas fa-list"></i> Lista de Productos (<?php echo count($products); ?>)</h2>
                    <?php if (!$show_form): ?>
                        <a href="admin_products.php?action=new" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Nuevo Producto
                        </a>
                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <?php if (empty($products)): ?>
                        <p class="no-data">No hay productos registrados. <a href="admin_products.php?action=new">Crear uno ahora</a></p>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Imagen</th>
                                        <th>Nombre</th>
                                        <th>Precio</th>
                                        <th>Categoría</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($products as $product): ?>
                                    <tr>
                                        <td>#<?php echo $product['id']; ?></td>
                                        <td>
                                            <img src="<?php echo htmlspecialchars($product['image']); ?>" 
                                                 alt="<?php echo htmlspecialchars($product['name']); ?>" 
                                                 class="product-thumb">
                                        </td>
                                        <td><?php echo htmlspecialchars($product['name']); ?></td>
                                        <td>$<?php echo number_format($product['price'], 2); ?></td>
                                        <td><span class="badge badge-category"><?php echo htmlspecialchars($product['category']); ?></span></td>
                                        <td class="actions">
                                            <a href="admin_products.php?edit=<?php echo $product['id']; ?>" class="btn-icon btn-edit" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form method="POST" style="display: inline;" onsubmit="return confirm('¿Estás seguro de eliminar este producto?');">
                                                <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                                                <button type="submit" name="delete_product" class="btn-icon btn-delete" title="Eliminar">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
