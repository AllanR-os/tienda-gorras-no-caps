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
    if (isset($_POST['update_role'])) {
        $user_id = intval($_POST['user_id']);
        $role = sanitizeInput($_POST['role']);
        
        if (updateUserRole($con, $user_id, $role)) {
            $message = "Rol actualizado exitosamente";
            $message_type = "success";
        } else {
            $message = "Error al actualizar el rol";
            $message_type = "error";
        }
    } elseif (isset($_POST['delete_user'])) {
        $user_id = intval($_POST['user_id']);
        
        // No permitir que el admin se elimine a sí mismo
        if ($user_id == $_SESSION['user_id']) {
            $message = "No puedes eliminar tu propia cuenta";
            $message_type = "error";
        } else {
            if (deleteUser($con, $user_id)) {
                $message = "Usuario eliminado exitosamente";
                $message_type = "success";
            } else {
                $message = "Error al eliminar el usuario";
                $message_type = "error";
            }
        }
    }
}

// Obtener todos los usuarios
$users = getAllUsers($con);

// Separar usuarios por rol
$admins = array_filter($users, function($user) { return $user['role'] == 'admin'; });
$clientes = array_filter($users, function($user) { return $user['role'] == 'cliente'; });
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios - Desert Caps</title>
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
            <li><a href="admin_products.php"><i class="fas fa-box"></i> Productos</a></li>
            <li><a href="admin_users.php" class="active"><i class="fas fa-users"></i> Usuarios</a></li>
            <li><a href="pagina_principal.php" target="_blank"><i class="fas fa-store"></i> Ver Tienda</a></li>
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="topbar">
            <h1>Gestión de Usuarios</h1>
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

            <!-- Estadísticas de Usuarios -->
            <div class="stats-grid" style="grid-template-columns: repeat(2, 1fr);">
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <div class="stat-info">
                        <h3><?php echo count($admins); ?></h3>
                        <p>Administradores</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-info">
                        <h3><?php echo count($clientes); ?></h3>
                        <p>Clientes</p>
                    </div>
                </div>
            </div>

            <!-- Lista de Usuarios -->
            <div class="card">
                <div class="card-header">
                    <h2><i class="fas fa-list"></i> Todos los Usuarios (<?php echo count($users); ?>)</h2>
                </div>
                <div class="card-body">
                    <?php if (empty($users)): ?>
                        <p class="no-data">No hay usuarios registrados.</p>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Usuario</th>
                                        <th>Email</th>
                                        <th>Rol</th>
                                        <th>Fecha Registro</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($users as $user): ?>
                                    <tr>
                                        <td>#<?php echo $user['id']; ?></td>
                                        <td>
                                            <div class="user-cell">
                                                <i class="fas fa-user-circle"></i>
                                                <span><?php echo htmlspecialchars($user['user_name']); ?></span>
                                            </div>
                                        </td>
                                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                                        <td>
                                            <?php if ($user['id'] == $_SESSION['user_id']): ?>
                                                <span class="badge badge-<?php echo $user['role'] == 'admin' ? 'admin' : 'client'; ?>">
                                                    <?php echo ucfirst($user['role']); ?> (Tú)
                                                </span>
                                            <?php else: ?>
                                                <form method="POST" style="display: inline;">
                                                    <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                                    <select name="role" onchange="this.form.submit()" class="role-select">
                                                        <option value="cliente" <?php echo $user['role'] == 'cliente' ? 'selected' : ''; ?>>Cliente</option>
                                                        <option value="admin" <?php echo $user['role'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
                                                    </select>
                                                    <button type="submit" name="update_role" style="display: none;"></button>
                                                </form>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo date('d/m/Y H:i', strtotime($user['date'])); ?></td>
                                        <td class="actions">
                                            <?php if ($user['id'] != $_SESSION['user_id']): ?>
                                                <form method="POST" style="display: inline;" onsubmit="return confirm('¿Estás seguro de eliminar este usuario? Se eliminarán también sus datos del carrito.');">
                                                    <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                                    <button type="submit" name="delete_user" class="btn-icon btn-delete" title="Eliminar">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            <?php else: ?>
                                                <span class="text-muted" style="font-size: 0.8em;">No puedes eliminar tu propia cuenta</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Información adicional -->
            <div class="card">
                <div class="card-header">
                    <h2><i class="fas fa-info-circle"></i> Información</h2>
                </div>
                <div class="card-body">
                    <div class="info-list">
                        <div class="info-item">
                            <i class="fas fa-shield-alt"></i>
                            <div>
                                <strong>Roles de Usuario</strong>
                                <p>Los <strong>Clientes</strong> solo pueden acceder a la tienda. Los <strong>Administradores</strong> tienen acceso completo al panel de administración.</p>
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-exclamation-triangle"></i>
                            <div>
                                <strong>Precaución</strong>
                                <p>Al eliminar un usuario, se eliminarán también todos los productos en su carrito. Esta acción no se puede deshacer.</p>
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-user-plus"></i>
                            <div>
                                <strong>Nuevos Usuarios</strong>
                                <p>Los usuarios se registran por defecto como <strong>Clientes</strong>. Puedes cambiar su rol aquí cuando sea necesario.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
