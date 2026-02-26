<?php
session_start();
include("connection.php");
include("functions.php");
include("admin_functions.php");

// Verificar si el usuario es administrador
$user_data = check_admin($con);

// Obtener estadísticas
$stats = getDashboardStats($con);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Administrativo - Desert Caps</title>
    <link rel="icon" type="image/png" href="https://img.freepik.com/vector-premium/plantilla-maquillaje-vectorial-gorra-beisbol-blanca-realista-3d-aislada-sobre-fondo-blanco_272204-23479.jpg?semt=ais_hybrid">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="admin_styles.css">
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h2><i class="fas fa-hat-cowboy"></i> NO Caps</h2>
            <p>Panel Admin</p>
        </div>
        <ul class="sidebar-menu">
            <li><a href="admin_panel.php" class="active"><i class="fas fa-dashboard"></i> Dashboard</a></li>
            <li><a href="admin_products.php"><i class="fas fa-box"></i> Productos</a></li>
            <li><a href="admin_users.php"><i class="fas fa-users"></i> Usuarios</a></li>
            <li><a href="pagina_principal.php" target="_blank"><i class="fas fa-store"></i> Ver Tienda</a></li>
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="topbar">
            <h1>Dashboard</h1>
            <div class="user-info">
                <i class="fas fa-user-circle"></i>
                <span>Bienvenido, <?php echo htmlspecialchars($user_data['user_name']); ?></span>
            </div>
        </div>

        <div class="content">
            <!-- Tarjetas de estadísticas -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <i class="fas fa-box"></i>
                    </div>
                    <div class="stat-info">
                        <h3><?php echo $stats['total_products']; ?></h3>
                        <p>Total Productos</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-info">
                        <h3><?php echo $stats['total_users']; ?></h3>
                        <p>Usuarios Registrados</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div class="stat-info">
                        <h3><?php echo $stats['total_cart_items']; ?></h3>
                        <p>Items en Carritos</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                        <i class="fas fa-layer-group"></i>
                    </div>
                    <div class="stat-info">
                        <h3><?php echo count($stats['products_by_category']); ?></h3>
                        <p>Categorías</p>
                    </div>
                </div>
            </div>

            <!-- Productos por Categoría -->
            <div class="card">
                <div class="card-header">
                    <h2><i class="fas fa-chart-pie"></i> Productos por Categoría</h2>
                </div>
                <div class="card-body">
                    <?php if (!empty($stats['products_by_category'])): ?>
                        <div class="category-list">
                            <?php foreach ($stats['products_by_category'] as $category => $count): ?>
                                <div class="category-item">
                                    <div class="category-name">
                                        <i class="fas fa-tag"></i>
                                        <span><?php echo htmlspecialchars($category); ?></span>
                                    </div>
                                    <div class="category-count">
                                        <span class="badge"><?php echo $count; ?> productos</span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="no-data">No hay productos registrados aún.</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Accesos Rápidos -->
            <div class="card">
                <div class="card-header">
                    <h2><i class="fas fa-bolt"></i> Accesos Rápidos</h2>
                </div>
                <div class="card-body">
                    <div class="quick-actions">
                        <a href="admin_products.php?action=new" class="action-btn">
                            <i class="fas fa-plus-circle"></i>
                            <span>Agregar Producto</span>
                        </a>
                        <a href="admin_products.php" class="action-btn">
                            <i class="fas fa-list"></i>
                            <span>Ver Productos</span>
                        </a>
                        <a href="admin_users.php" class="action-btn">
                            <i class="fas fa-user-plus"></i>
                            <span>Gestionar Usuarios</span>
                        </a>
                        <a href="pagina_principal.php" target="_blank" class="action-btn">
                            <i class="fas fa-external-link-alt"></i>
                            <span>Ver Tienda</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Animación de números
        document.querySelectorAll('.stat-info h3').forEach(element => {
            const target = parseInt(element.textContent);
            let current = 0;
            const increment = target / 50;
            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    element.textContent = target;
                    clearInterval(timer);
                } else {
                    element.textContent = Math.floor(current);
                }
            }, 20);
        });
    </script>
</body>
</html>
